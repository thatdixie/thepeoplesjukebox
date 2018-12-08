<?php
require_once "../include/view/page/capstone/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
siteSession();

$db       = new UserProfileModel();
$db2      = new UserMediaModel();
$profile  = $db->find(3);
$media    = $db2->findCurrentlyPlaying(3);

setUserSession("userId", 3);
setUserSession("userName", "cyrusface@gmail.com");
setUserSession("userPasscode", $profile[0]->userPasscode);

viewJukebox($profile, $media);



?>
