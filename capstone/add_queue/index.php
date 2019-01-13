<?php
/**
 * Request to play a song on a jukebox
 *
 * POST to:
 * http://ThePeoplesJukebox/capstone/add_queue/
 *
 * REST PARAMS:
 *   jukeboxId
 *   mediaId
 *
 * @author  dixie
 **
*/
require_once "UserSession.php";

$u         = new UserSession();
$jukeboxId = getRequest('jukeboxId');
$mediaId   = getRequest('mediaId');
    
if(($user = $u->getUserSession($jukeboxId)))
{
    $requestId    = $user[0]->userId;
    $db           = new UserPlaylistModel();
    $playlist     = $db->findUserPlaylist($jukeboxId);
    $select_limit = false;
    $select_max   = maxUserPlayLimit(); 
    $select_count =0;
    
    if($playlist)
        $count = count($playlist);
    else
        $count = 0;

    for($i=0; $i <$count; $i++)
    {
        if($playlist[$i]->playlistUserId == $requestId)
        {
            if($select_count++ == $select_max)
            {
                $select_limit = true;
                break;
            }
        }
    }

    if($select_limit)
    {       
        $notPlaylist                  = new Playlist();
        $notPlaylist->userId          = $jukeboxId;
        $notPlaylist->mediaId         = $mediaId;
        $notPlaylist->playlistUserId  = $requestId;
        $notPlaylist->playlistOrder   = $select_max;
        $notPlaylist->playlistCreated = sqlNow();
        $notPlaylist->playlistModified= sqlNow();
        $notPlaylist->playlistStatus  = "PLAY_LIMIT";
        jsonResponse($notPlaylist->makeJSON());
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
        jsonResponse($newPlaylist->makeJSON());
    }
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
