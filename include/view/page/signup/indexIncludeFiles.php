<?php

/***********************************
 * views for /signup/index.php 
 *
 * @author  dixie
 ***********************************
*/			
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/view/page/index/head.php";
require_once $root."/include/view/page/index/nav.php";
require_once "signupForm.php";
require_once $root."/include/view/page/index/foot.php";

?>
