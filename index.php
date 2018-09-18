<?php
require_once "include/view/page/index/indexIncludeFiles.php";
require_once "include/model/AdminFaqModel.php";

head();
nav();
about();
why();
$db   = new AdminFaqModel();
$faqs = $db->findAll(); 
faq($faqs);
//contact();
foot();

?>



