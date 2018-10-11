<?php
/**
 * Get play queue on a jukbox
 *
 * POST to:
 * http://ThePeoplesJukebox/api/play_queue/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   jukeboxId
 *
 * @author  dixie
 **
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $db = new UserMediaModel();
    $medias = $db->findPlayQueue(getRequest('jukeboxId'));
    if($medias)
        jsonResponse(json_encode($medias));
    else
        jsonErrorResponse("200", "EMPTY");        
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
