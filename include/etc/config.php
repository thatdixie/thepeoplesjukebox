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

function pubServerAddress()
{
    return("http://thepeoplesjukebox.com");
    //return("http://temp.metaq");
}

function smtpConfig()
{
    return("/opt/install/PHPMailer/PHPMailer.json");
}

function mp3Data()
{
    return("/opt/data2/jukebox/");
}

function photoData()
{
    return("/opt/data2/jukebox/");
}

function maxUserPlayLimit()
{
    return(2);
}

function configValidPhotoExtensions()
{
    $validExtensions =  ['jpg', 'jpeg', 'png', 'gif'];
    return($validExtensions);
}

function configValidMediaExtensions()
{
    $validExtensions = ['mp3', 'mp4a'];
    return($validExtensions);
}

function configMaxUploadSize()
{
    // I'm not sure how I got this number LOL
    //---------------------------------------
    return(2097152);
}

function defaultMediaFile()
{
    return("rock lobster.mp3");
}

function defaultMediaArtist()
{
    return("The B-52's");
}

function defaultMediaTitle()
{
    return("Rock Lobster");
}

?>
