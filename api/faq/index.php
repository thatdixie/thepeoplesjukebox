<?php
/***********************************
 * REST faq for TPJ
 *
 * GET to:
 * http://ThePeoplesJukebox/api/faq/
 *
 * REST PARAMS:
 *   N/A
 *
 * @author  dixie
 ***********************************
*/
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root."/include/etc/session.php";
require_once $root."/include/etc/random.php";
require_once $root."/include/etc/json.php";
require_once $root."/include/model/AdminFaqModel.php";

$db   = new AdminFaqModel();
$faqs = $db->findAll();
jsonResponse(json_encode($faqs));

?>
