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
require_once "UserSession.php";

$u     = new UserSession();
    
if(($user = $u->login(getRequest('username'), getRequest('password'))))
{
    jsonResponse($user->makeJson());
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
