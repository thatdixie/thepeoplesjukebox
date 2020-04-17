<?php
/**
 * Render a profile photo
 *
 * @author  dixie
 **
*/
require_once "../include/etc/session.php";
require_once "../include/etc/config.php";
require_once "../include/model/UserModel.php";
siteSession();

$db  = new UserModel();
$id  = getRequest("userId");
$user= $db->find($id);
if($user)
{
    $file = $user[0]->userPhoto;
    if($file == "NO")
        $photofile = realpath($_SERVER['DOCUMENT_ROOT'])."/images/defaultProfile.jpeg";
    else
        $photofile = photoData().$id."/photos/".$file;
}
else
    $photofile = realpath($_SERVER['DOCUMENT_ROOT'])."/images/defaultProfile.jpeg";

error_log($photofile,0);
$getInfo = getimagesize($photofile);
header('Content-type: '. $getInfo['mime']);
ob_clean();
flush();
readfile($photofile)
?>


