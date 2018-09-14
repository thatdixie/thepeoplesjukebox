<?php
/***********************************
 * config.php
 * @author  mgill
 ***********************************
*/			

function systemEmail()
{
    $admins = array('mgill@metaqueue.net',
                    'cyrusface@gmail.com');
    return($admins);
}

function pubServerAddress()
{
    return("http://jukebox.thatdixie.com");
}

function smtpConfig()
{
    return("/opt/install/PHPMailer/PHPMailer.json");
}

?>
