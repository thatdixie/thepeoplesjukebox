<?php
//---------------------------------
// load CAPTCHA page
//----------------------------------
require_once "../include/view/page/captcha/indexIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

head();
nav();
captcha();
foot();
?>
