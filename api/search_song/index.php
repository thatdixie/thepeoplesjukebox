<?php
/**
 * Search for a song on a jukebox
 *
 * POST to:
 * http://ThePeoplesJukebox/api/search_song/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   jukeboxId
 *   searchKey
 *
 * @author  dixie
 **
*/
require_once "../login/UserSession.php";

$u     = new UserSession();

if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $jukeboxId = getRequest('jukeboxId');
    $searchKey = getRequest('searchKey');
    $db        = new UserMediaModel();
    $medias    = $db->findBySearchKey($jukeboxId, $searchKey);

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
