<?php
/**
 * Get/Play song on a jukbox queue
 ***************************************
 * This version is only called by the 
 * dixie.js when it's an iPhone 
 ***************************************
 *
 * @author  dixie
 **
*/
require_once "../include/etc/random.php";
require_once "../include/etc/session.php";
require_once "../include/etc/config.php";
require_once "../include/model/UserMediaModel.php";
require_once "../include/model/UserPlaylistModel.php";
siteSession();

$db         = new UserPlaylistModel();
$jukeboxId  = getRequest("jukeboxId");
$userId     = getRequest("userId");
$isIphoneUI = isIphoneUI();

//---------------------------------------------------
// We only select next song if the user IS a jukebox
// and it's NOT the "AppleCoreMedia" UserAgent that
// is weirdly sent by Apple devices...
//---------------------------------------------------
if(getRequest(($jukeboxId==$userId) && !$isIphoneUI))
    $media = $db->findNextInQueue($jukeboxId);
else
    $media = $db->getCurrentlyPlaying($jukeboxId);

if($media)
{
    if($media[0]->mediaId==0)
        $mp3file = mp3Data()."default/songs/".defaultMediaFile();
    else
        $mp3file = mp3Data().$id."/songs/".$media[0]->mediaFile;
}
else
    $mp3file = mp3Data()."default/songs/".defaultMediaFile();

$size    = filesize($mp3file);

header("Accept-Ranges: bytes");
header("Content-Range: 0-".$size."/*");
header("Content-Type: audio/mpeg");
header("Content-Length: ".$size);
header("Content-Disposition: attachment; filename=".$mp3file);
header("Cache-Control: no-cache");
echo file_get_contents($mp3file, TRUE);
?>


