<?php
require_once "include/etc/session.php";
require_once "include/etc/ipstack.php";
require_once "include/view/page/index/indexIncludeFiles.php";
require_once "include/model/AdminFaqModel.php";
require_once "include/model/UserProfileModel.php";
siteSession();
//-----------------------------------
// partials for head and navigation
// and page content and footer...
//-----------------------------------
head();
nav();
//-----------------------------------
// We want to show Jukebox's near
// the users browser...
//
// using ipstack http://ipstack.com 
//-----------------------------------
ipstack();  
$db       = new UserProfileModel();
$long     = getUserSession('LOC_LONGITUDE');
$lat      = getUserSession('LOC_LATITUDE');
$profiles = $db->findJukeBoxNearMe($long, $lat); 
about($profiles);
//-----------------------------------
// State the value proposition...
//-----------------------------------
why();
//-----------------------------------
// TPJ FAQ's
//-----------------------------------
$db   = new AdminFaqModel();
$faqs = $db->findAll(); 
faq($faqs);
//----------------------------------
// skip the inline contact form
//----------------------------------
//contact();
foot();

?>



