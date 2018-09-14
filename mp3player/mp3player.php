<?php

require_once "../include/etc/random.php";
require_once "../include/etc/session.php";
siteSession();

//-------------------------------------------
// a very silly implementation of
// circular queue becasue I'm tired LOL
//-------------------------------------------
$mysong = $_SESSION['mysong'];
$foo    = $mysong."mp3";

if($mysong==0)
    $mysong=1;
elseif($mysong==1)
    $mysong=2;
elseif($mysong==2)
    $mysong=3;
else
    $mysong=0;

$_SESSION['mysong'] = $mysong;

$size = filesize($foo);

header("Accept-Ranges: bytes");
header("Content-Range: 0-".$size."/*");
header("Content-Type: audio/mpeg");
header("Content-Length: ".$size);
header("Content-Disposition: attachment; filename=".$foo);
header("Cache-Control: no-cache");
echo file_get_contents($foo, TRUE);

?>


