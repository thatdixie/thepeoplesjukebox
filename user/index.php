<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
siteSession();

if(isAdminLoginOK())
{
    switch(getRequest("func"))
    {
        case "player": 
        playJukebox(getRequest("jukeboxId"));
        break;

        case "find_jukebox":
        findJukebox(getRequest("userId"));
        break;
   
        case "edit_profile":
        editProfile(getUserSession("userId"));
        break;
    
        case "edit_catalog":
        editCatalog(getRequest("userId"));
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

/*
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

/*
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

function findJukebox()
{
    redirect("/");
}


function editCatalog()
{
    redirect("/");    
}

?>



