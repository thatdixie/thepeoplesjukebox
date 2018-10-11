<?php
/**
 * Get play next song on a jukbox queue
 *
 * POST to:
 * http://ThePeoplesJukebox/api/play_next/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *
 * @author  dixie
 **
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $db = new UserPlaylistModel();
    $medias = $db->findNextInQueue($user[0]->userId);
    if($medias)
    {
        $medias[0]->mediaFile = pubServerAddress()."/mp3player/mp3player.php?jukeboxId=".$user[0]->userId;
        jsonResponse(json_encode($medias[0]));
    }
    else
        jsonErrorResponse("500", "Could Not Get Queue");        
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
