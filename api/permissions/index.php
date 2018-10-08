<?php
/***********************************
 * REST get user permissions for TPJ
 *
 * POST to:
 * http://ThePeoplesJukebox/api/permissions/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *
 * @author  dixie
 ***********************************
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($permissions = $u->getUserPermissions(getRequest('username'), getRequest('passcode'))))
{
    jsonResponse(json_encode($permissions));
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
