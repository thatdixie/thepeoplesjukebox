<?php
/**
 * Get currently playing on a jukbox
 *
 * POST to:
 * http://ThePeoplesJukebox/api/currently_playng/
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
    $medias = $db->findCurrentlyPlaying(getRequest('jukeboxId'));
    if($medias)
        jsonResponse(json_encode($medias[0]));
    else
        jsonErrorResponse("200", "EMPTY");        
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
