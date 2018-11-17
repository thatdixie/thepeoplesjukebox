<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
siteSession();

if(isAdminLoginOK())
{
    $func         = getRequest("func");
    $jukeboxId    = getRequest("jukeboxId");

    if($func=="player")
    {
        playJukebox($jukeboxId);
    }
    elseif($func=="find_jukebox")
    {
        findJukebox();
    }
    elseif($func=="edit_profile")
    {
        editProfile();
    }
    elseif($func == "edit_catalog")
    {
        editCatalog();
    }
    else
    {
        // This should never happen
        // Else need to debug 
        redirect("/");
    }
}
else
{
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

function findJukebox()
{
    redirect("/");
}

function editProfile()
{
    redirect("/");    
}

function editCatalog()
{
    redirect("/");    
}

?>



