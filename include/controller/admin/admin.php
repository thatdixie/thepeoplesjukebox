<?php

/***********************************
 * admin login for thatdixie.com
 *
 * @author  dixie
 ***********************************
*/
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root."/include/etc/sql.php";
require_once $root."/include/etc/session.php";
require_once $root."/include/model/UserModel.php";
require_once $root."/include/model/UserPermissionsModel.php";
require_once $root."/include/model/UserLoginModel.php";
require_once $root."/include/etc/ipstack.php";

/*
 * validates a username/password
 *
 * @param  string $u username
 * @param  string $p password
 * @return bool 
 * 
**/			
function adminLogin($u, $p)
{
    $db = new UserLoginModel();
    
    if(($user = $db->findUserLogin($u, $p)))
    {
        setAdminLoginOk();
        setUserSession('userName'     , $user->userName);
        setUserSession('userFirstName', $user->userFirstName);
	setUserSession('userLastName' , $user->userLastName);
	setUserSession('userStatus'   , $user->userStatus);
	setUserSession('userLastLogin', toHumanDate($user->userLastLogin));
        setUserSession('userId'       , $user->userId);
        setUserSession('userPasscode' , $user->userPasscode);
        setUserSession('nextLastLogin', sqlNow());
        setUserSession('userAgent'    , $_SERVER['HTTP_USER_AGENT']);
        setUserLocation($db, $user);
        getUserPermissions($user->userId);
        //error_log($_SERVER['HTTP_USER_AGENT'],0);
	    return(true);
    }
    else
    {
        return(false);
    }
}

/*
 * logout of admin
 *
 * @param  n/a
 * @return n/a
 * 
**/			
function adminLogout()
{
    $db = new UserModel();

    $users = $db->find(getUserSession('userId'));
    $user  = $users[0];
    $user->userLastLogin = getUserSession('nextLastLogin');
    $db->update($user);
    unSetAdminLoginOK();
    session_unset();
}


/*
 * returns the permissions for a user
 * also sets $_SESSION[] 
 *
 * @param  int  $u userId
 * @return array  $permissions 
 * 
**/			
function getUserPermissions($u)
{
    $db          = new UserPermissionsModel();
    $permissions = $db->findUserPermissions($u);

    foreach($permissions as $permission)
    {
        setPermission($permission->permissionName);
    }
    return($permissions);
}

/*
 * returns the groupss for a user
 *
 * @param  class  $u User
 * @return array  $groups 
 * 
**/			
function getUserGroups($u)
{
    return("");
}

/*
 * redirects to most correct user landing page
 *
 * @param  n/a
 * @return n/a 
 * 
**/			
function findUserHomePage()
{
    if(!isSiteAdmin())
    {
        //-----------------------------------------
        // You're not a site admin go to regular
        // jukebox page or home page.
        //-----------------------------------------
        $dest = getLoginDestination();
        if($dest != "")
            redirect($dest);
        else if(hasPermission("canJukeboxAdmin"))
            redirect("/user/index.php?jukeboxId=".getUserSession("userId")."&func=player");
        else
            redirect("/");
    }
    else
    {
        //-----------------------------------------------------
        // OK, so we're logged-in as a site admin
        // ...Go to admin inbox
        //-----------------------------------------------------
        redirect("/admin/index.php?func=inbox");
   }
}
    
/*
 * returns true if user is a site admin login
 *
 * @param  n/a
 * @return boolean -- true or false
 * 
**/			
function isSiteAdmin()
{
    if(hasPermission("canPublish")
    || hasPermission("canUserEdit")
    || hasPermission("canContentEdit"))
        return(true);
    else
        return(false);
}

    
/*
 * updates longitude and latitude in the user table
 *
 * @param  $db
 * @param  $user
 * 
**/			
function setUserLocation($d, $u)
{
    ipstack();     //loads IP info into session
    $u->userLongitude = getUserSession('LOC_LONGITUDE');
    $u->userLatitude  = getUserSession('LOC_LATITUDE');
    $d->update($u);
}


?>
