<?php
/**
 * Get play next song on a jukbox queue
 * if the user owns the jukebox then find 
 * next in queue otherwise find currently 
 * playing in selected jukebox.
 *
 * POST to:
 * http://ThePeoplesJukebox/capstone/play_next/
 *
 * REST PARAMS:
 *   jukeboxId
 *
 * @author  dixie
 **
*/
require_once "UserSession.php";

$u         = new UserSession();
$jukeboxId = getRequest("jukeboxId");

if(($user = $u->getUserSession($jukeboxId)
{
    $db = new UserPlaylistModel();
    $medias = $db->findNextInQueue($jukeboxId);
    
    if($medias)
    {
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
