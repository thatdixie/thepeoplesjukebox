<?php

require_once "../include/etc/random.php";
require_once "../include/etc/session.php";
siteSession();

if($_SESSION['mysong'])
{
    $_SESSION['mysong'] = 0;
    $foo = "rl.mp3";
}
else
{
    $_SESSION['mysong'] = 1;
    $foo = "sl.mp3";    
}

$size = filesize($foo);

     header("Content-Type: audio/mpeg");
     header("Accept-Ranges: bytes");
     header("Cache-Control: max-age=0");
     header("Content-Length: ".$size);
     header("Content-Disposition: attachment; filename=".$foo);
    echo file_get_contents($foo, TRUE);

?>


