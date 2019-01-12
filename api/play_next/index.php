<?php
/**
 * Get play next song on a jukbox queue
 * if the user owns the jukebox then find 
 * next in queue otherwise find currently 
 * playing in selected jukebox.
 *
 * POST to:
 * http://ThePeoplesJukebox/api/play_next/
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

$u         = new UserSession();
$jukeboxId = getRequest("jukeboxId");

if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $db = new UserPlaylistModel();
    if($jukeboxId == $user[0]->userId)
        $medias = $db->findNextInQueue($jukeboxId);
    else
        $medias = $db->getCurrentlyPlaying($jukeboxId);
        
    if($medias)
    {
        if($medias[0]->mediaSource == "UPLOAD")
            $medias[0]->mediaFile = pubServerAddress()."/mp3player/mp3player.php?jukeboxId=".$jukeboxId;
        jsonResponse(json_encode($medias[0]));
    }
    else
    {
        $media = new Media();
        $media->mediaSource = "UPLOAD";
        $media->mediaArtist = defaultMediaArtist();
        $media->mediaTitle  = defaultMediaTitle();
        $media->mediaFile   = pubServerAddress()."/mp3player/mp3player.php?jukeboxId=".$jukeboxId;
        jsonResponse(json_encode($media));        
    }
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
