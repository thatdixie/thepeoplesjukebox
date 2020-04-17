<?php
//---------------------------------
// load signup form page
//----------------------------------
require_once "../include/view/page/signup/indexIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

if(isCaptchaOK())
    redirect("/signup/signup.php");
    
head();
nav();
signup();
foot();
?>
