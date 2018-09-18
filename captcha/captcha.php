<?php

require_once "../include/etc/session.php";
siteSession();

if($_REQUEST['captchaCode'] == $_SESSION['captcha']['code'])
{
    //---------------------------------
    // set OK status in session and
    // redirect to target page
    //----------------------------------
    setCaptchaOK();
    redirect($_REQUEST['captchaPage']);
}
else
{
    //---------------------------------
    // reload CAPTCHA page
    //----------------------------------
    redirect("/captcha/getcaptcha.php");
}
?>
