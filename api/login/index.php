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
require_once $root."/include/etc/random.php";
require_once $root."/include/etc/json.php";
require_once $root."/include/model/UserLoginModel.php";

$username = getRequest('username');
$password = getRequest('password');

if($username && $password)
{
    $db     = new UserLoginModel();
    
    if(($user = $db->findUserLogin($username, $password)))
    {
        //-------------------------------------
        // Generate a passcode so that
        // future API requests may use
        // username/passcode
        //-------------------------------------
        $user->userPasscode = randomString(10);
        $db->update($user);

        jsonResponse($user->makeJson());
        error_log($user->makeJson(),0);
    }
    else
    {
        jsonErrorResponse("404", "User Not Found");
    }
}

?>
