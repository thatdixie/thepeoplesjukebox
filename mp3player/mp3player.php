<?php
/**
 * Get/Play next song on a jukbox queue
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

$db = new UserPlaylistModel();
$id = getRequest("jukeboxId");
if(getRequest("select") == "yes")
    $media = $db->findNextInQueue($id);
else
    $media = $db->getCurrentlyPlaying($id);

$mp3file = mp3Data().$id."/songs/".$media[0]->mediaFile;
$size    = filesize($mp3file);

header("Accept-Ranges: bytes");
header("Content-Range: 0-".$size."/*");
header("Content-Type: audio/mpeg");
header("Content-Length: ".$size);
header("Content-Disposition: attachment; filename=".$mp3file);
header("Cache-Control: no-cache");
echo file_get_contents($mp3file, TRUE);

/*
$getInfo = getimagesize($mp3file);
header('Content-type: '. $getInfo['mime']);
ob_clean();
flush();
readfile($mp3file)*/
?>


