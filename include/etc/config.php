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
    return("http://thepeoplesjukebox.com");
}

function smtpConfig()
{
    return("/opt/install/PHPMailer/PHPMailer.json");
}

?>
