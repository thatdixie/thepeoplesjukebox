<?php
/***********************************
 * Get User Catalog for TPJ
 *
 * POST to:
 * http://ThePeoplesJukebox/api/catalog/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   jukeboxId
 *
 * @author  dixie
 ***********************************
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $db = new UserMediaModel();
    $medias = $db->findByUserId(getRequest('jukeboxId'));
    jsonResponse(json_encode($medias));
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
