<?php
/**
 * Request to play a song on a jukbox
 *
 * POST to:
 * http://ThePeoplesJukebox/api/add_queue/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   jukeboxId
 *   mediaId
 *
 * @author  dixie
 **
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $jukeboxId    = getRequest('jukeboxId');
    $mediaId      = getRequest('mediaId');
    $requestId    = $user[0]->userId;
    $db           = new UserPlaylistModel();
    $playlist     = $db->findUserPlaylist($jukeboxId);
    $select_limit = false;
    
    if($playlist)
        $count = count($playlist);
    else
        $count = 0;

    for($i=0; $i <$count; $i++)
    {
        if($playlist[$i]->playlistUserId == $requestId)
        {
            $select_limit = true;
            break;
        }
    }

    if($select_limit)
    {       
        jsonErrorResponse("200", "USER_PLAY_LIMIT");
    }
    else
    {
        $newPlaylist                  = new Playlist();
        $newPlaylist->userId          = $jukeboxId;
        $newPlaylist->mediaId         = $mediaId;
        $newPlaylist->playlistUserId  = $requestId;
        $newPlaylist->playlistOrder   = $count + 1;
        $newPlaylist->playlistCreated = sqlNow();
        $newPlaylist->playlistModified= sqlNow();
        $newPlaylist->playlistStatus  = 'QUEUE';
        $newPlaylist = $db->insert2($newPlaylist);
        jsonResponse(json_encode($newPlaylist));
    }
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
