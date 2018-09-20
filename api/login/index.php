<?php
/***********************************
 * REST login for TPJ
 *
 * POST to:
 * http://ThePeoplesJukebox/api/login/
 *
 * REST PARAMS:
 *   username
 *   password
 *
 * @author  dixie
 ***********************************
*/
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root."/include/etc/session.php";
require_once $root."/include/etc/sql.php";
require_once $root."/include/model/UserModel.php";
require_once $root."/include/model/UserPermissionsModel.php";
require_once $root."/include/model/UserLoginModel.php";

$username = getRequest('username');
$password = getRequest('password');

if($username && $password)
{
    $db     = new UserLoginModel();
    $apiUser= new ApiUser();
    
    if(($user = $db->findUserLogin($username, $password)))
    {
        $apiUser->login     = $user->userName;
        $apiUser->firstName = $user->userFirstName;
	    $apiUser->lastName  = $user->userLastName;
	    $apiUser->status    = $user->userStatus;
	    $apiUser->lastLogin = $user->userLastLogin;
        $apiUser->userId    = $user->userId;

        $db = new UserPermissionsModel();
        $permissions = $db->findUserPermissions($apiUser->userId);

        $apiUser->isJukebox = false;
        foreach($permissions as $permission)
        {
            if($permission->permissionName == "isJukebox")
                $apiUser->isJukebox = true;
        }

        jsonResponse($apiUser->makeJson());
    }
    else
    {
        jsonResponse($apiUser->makeJsonError("User Not Found"));
    }
}


?>
