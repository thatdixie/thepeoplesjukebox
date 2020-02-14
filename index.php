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
//-----------------------------------
ipstack();
$db       = new UserProfileModel();
$long     = getUserSession('LOC_LONGITUDE');  // actual GEO coord's
$lat      = getUserSession('LOC_LATITUDE');   // comming soon...
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



