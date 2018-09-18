<?php

//**********************************************************
// This is a TEMP signup STUB that uses CAPTCHA
// TODO: Actual signup and not just a contact insertion.
//**********************************************************

require_once "../include/etc/session.php";
siteSession();

if(isCaptchaOK())
{
    //------------------------------
    // CAPTCHA validated...
    //------------------------------
    require_once "../include/etc/notify.php";

    systemNotify("There was a signup");
    kissyface("Thank You!", "/user/");
}
else
{
    //--------------------------------------------------
    // CAPTCHA not validated yet...
    //--------------------------------------------------
    require "../include/view/page/captcha/indexIncludeFiles.php";
    $_SESSION['contactName']    = $_REQUEST['name'];
    $_SESSION['contactEmail']   = $_REQUEST['email'];
    $_SESSION['contactPhone']   = $_REQUEST['phone'];
    $_SESSION['contactSubject'] = "Signup";
    $_SESSION['contactMessage'] = "http://ThePeoplesJukebox.com";

    //-----------------------------------------------------
    // set this page as redirect after successful CAPTCHA
    //-----------------------------------------------------
    $_SESSION['captchaPage']    = "/signup/signup.php";

    //--------------------------------
    // This is the captcha page...
    //--------------------------------
    redirect("/captcha/getcaptcha.php"); 
}
?>


