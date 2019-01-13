<?php
/**
 * Search for a song on a jukebox
 *
 * POST to:
 * http://ThePeoplesJukebox/capstone/search_song/
 *
 * REST PARAMS:
 *   jukeboxId
 *
 * @author  dixie
 **
*/
require_once "UserSession.php";

$u         = new UserSession();
$jukeboxId = getRequest('jukeboxId');

if(($user = $u->getUserSession($jukeboxId)))
{
    $db        = new UserMediaModel();
    $medias    = $db->findBySearchKey($jukeboxId, "");

    if($medias)
        jsonResponse(json_encode($medias));
    else
        jsonErrorResponse("200", "No Songs Found");
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
