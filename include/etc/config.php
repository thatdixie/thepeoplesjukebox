<?php
/***********************************
 * config.php
 * @author  megan
 ***********************************
*/			

function systemEmail()
{
    $admins = array('mgill@metaqueue.net',
                    'cyrusface@gmail.com');
    return($admins);
}
/*
function pubServerAddress()
{
    return("http://jukebox");
}
*/

function pubServerAddress()
{
    return("http://thepeoplesjukebox.com");
}

function smtpConfig()
{
    return("/opt/install/PHPMailer/PHPMailer.json");
}

function mp3Data()
{
    return("/opt/data/jukebox/");
}

function photoData()
{
    return("/opt/data/jukebox/");
}
?>
