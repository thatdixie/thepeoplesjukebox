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
        setUserSession('nextLastLogin', sqlNow());
	    getUserPermissions($user->userId);

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


?>
