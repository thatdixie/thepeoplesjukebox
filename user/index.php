<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
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
 * updatePhoto()
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
        
        case "update_photo":
        updatePhoto(getUserSession("userId"));
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
    $db->update($user);
    
    redirect("/");
}

/**
 * updatePhoto -- update user profile photo
 *
 * @param $id -- this is the userId
 */
function updatePhoto($id)
{
    $db       = new UserProfileModel();
    $profile  = $db->find($id);

    viewEditProfile($profile);
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



