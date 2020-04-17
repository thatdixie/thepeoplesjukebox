<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/etc/config.php";
require_once "../include/etc/upload.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
require_once "../include/model/User_ugroupModel.php";
require_once "../include/model/UserUploadModel.php";
siteSession();

/**
 * This is the /user controller.
 *
 * functions:
 * --------------
 * playJukebox()
 * findJukebox()
 * editProfile()
 * updateProfile()
 * editCatalog()
 *
 * @author    Dixie
 * @copyright 2018
 *
 */
if(isAdminLoginOK())
{
    switch(getRequest("func"))
    {
        case "player": 
        playJukebox(getRequest("jukeboxId"));
        break;

        case "find_jukebox":
        findJukebox(getUserSession("userId"));
        break;
   
        case "edit_profile":
        editProfile(getUserSession("userId"));
        break;

        case "update_profile":
        updateProfile(getUserSession("userId"));
        break;
            
        case "edit_catalog":
        editCatalog(getUserSession("userId"));
        break;

        default:
        //---------------------------------
        // This never happens...
        // unless we got a bug or a hacker
        //---------------------------------
        redirect("/");
    }
}
else
{
    //------------------------------------
    // if we're not logged in, do that...
    //------------------------------------
    $func = getRequest("func");
    $id   = getRequest("jukeboxId");
    if($func == "player")
    {
        $dest = "/user/index.php?func=".$func."&jukeboxId=".$id;
        setLoginDestination($dest);
    }
    else
    {
        setLoginDestination("");
    }
    redirect("/login/");
}

/**
 * playJukebox -- set up user profile for jukebox
 *
 * @param $id -- this is the jukeboxId
 */
function playJukebox($id)
{
    $db       = new UserProfileModel();
    $db2      = new UserMediaModel();
    $profile  = $db->find($id);
    $media    = $db2->findCurrentlyPlaying($id);
    
    viewJukebox($profile, $media);
}

/**
 * editProfile -- edit user profile and allow 
 *                for changing profile photo
 *                password and becoming a jukebox
 *
 * @param $id -- this is the userId
 */
function editProfile($id)
{
    $db       = new UserProfileModel();
    $profile  = $db->find($id);

    viewEditProfile($profile);
}

/**
 * updateProfile -- update user profile
 *
 * @param $id -- this is the userId
 */
function updateProfile($id)
{    
    $db      = new UserProfileModel();
    $profile = $db->find($id);
    $user    = $profile[0];

    $user->userFirstName = getRequest('first');
    $user->userLastName  = getRequest('last');
    $user->userNickName  = getRequest('nickname');
    $user->userLikes     = getRequest('likes');
    $user->userWorkplace = getRequest('where');
    $user->userWorkHours = getRequest('when');
    $user->userIsJukebox = getRequest('jukebox');
    $user->userModified  = sqlnow();
    if(isFileUploaded())
    {
        //-------------------------------------
        // make sure user has a data directory
        //-------------------------------------
        $udir= photoData().$id;
        $dir = $udir."/photos/";
        
        if(!file_exists($udir))
            mkdir($udir);
        if(!file_exists($dir))
            mkdir($dir);
        //------------------------------------
        // Save uploaded photo...
        //------------------------------------
        $file =saveUploadedPhoto($dir);
        if($file)
        {
            //-------------------------------------------------------
            // resize image to width 256 and proportional height...
            //-------------------------------------------------------
            exec("convert ".$dir.$file." -resize 256 ".$dir.$file." > /dev/null");
            $user->userPhoto = $file;
        }
        else
        {
            error_log("Saving uploaded file failed...",0);
            $user->userPhoto = $profile[0]->userPhoto;
        }
    }
    //-------------------------------------------
    // check values for goodness before updating
    //-------------------------------------------
    if((!$user->userFirstName)
     ||(!$user->userLastName)
     ||(!$user->userNickName)
    )
    {
        if(!$user->userNickName)
            $user->userNickName  ="NO";
        if(!$user->userFirstName)
            $user->userFirstName ="First Name";
        if(!$user->userLastName)
            $user->userLastName  ="Last Name";
        $user->userIsJukebox     = "NO";
        $db->update($user);
        //------------------------------------------------------
        // Offer to update profile with better values...
        //------------------------------------------------------
        redirect("/user/index.php?func=edit_profile&errors=yes");
    }
    else if($user->userIsJukebox == "YES")
    {
        //-------------------------------------
        // if we're a jukebox now, gonna
        // need a mp3 folder and an Upload
        // record and jukebox permissions...
        //-------------------------------------
        $udir= mp3Data().$id;
        $dir = $udir."/songs/";
        
        if(!file_exists($udir))
            mkdir($udir);
        if(!file_exists($dir))
            mkdir($dir);
        //---------------------------------------
        // Add user to 'jukeboxAdmin' group
        //---------------------------------------
        if(!hasPermission('canJukeboxAdmin'))
        {
            $db2 = new User_ugroupModel();
            $ug  = new User_ugroup();
            $ug->userId   = $user->userId;
            $ug->ugroupId = 3; //this is a 'jukeboxAdmin'
            $db2->insert($ug);
            setPermission('canJukeboxAdmin');
        }
        //-------------------------------------------
        // Create upload record if it's not there...
        //-------------------------------------------
        $db3    = new UserUploadModel();
        $upload = $db3->findByUserId($user->userId);
        if(!$upload)
        {
            $up = new Upload();
            $up->userId        = $user->userId;
            $up->uploadSource  = "UPLOAD";
            $up->uploadCreated = sqlNow();
            $up->uploadModified= sqlNow();
            $up->uploadStatus  = "COMPLETE";
            $db3->insert($up);
        }
        //------------------------------------------------------
        // Go to "My-Catalog" to update songs...
        //------------------------------------------------------
        $db->update($user);
        redirect("/user/index.php?func=player&catalog=yes&jukeboxId=".$user->userId);        
    }
    else
    {
        //-----------------------------------------------
        // Otherwise, remove from jukeboxAdmin group and
        // go find a jukebox to play...
        //-----------------------------------------------
        unsetPermission('canJukeboxAdmin');
        $db4 = new User_ugroupModel();
        $db4->delete($user->userId,3);
        $db->update($user);
        redirect("/user/index.php?func=find_jukebox");        
    }
}


/**
 * findJukebox -- show page with find jukebox 
 *                search form.
 *
 * @param $id -- this is the userId
 */
function findJukebox($id)
{
    $db       = new UserProfileModel();
    $profile  = $db->find($id);
    
    viewfindJukebox($profile);
}


function editCatalog()
{
    redirect("/");    
}

?>
