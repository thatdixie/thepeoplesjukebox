<?php

/***********************************
 * views for TPJ
 * /admin/users.php 
 *
 * @author  dixie
 ***********************************
*/			
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/config.php";

require_once "head.php";
require_once "nav.php";
require_once "viewusers.php";
require_once "viewedituser.php";
require_once "viewadduser.php";
require_once "viewemail.php";
require_once "foot.php";

?>
