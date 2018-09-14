<?php
/***********************************
 * notify.php
 * @author  megan
 ***********************************
*/			
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once "sql.php";
require_once "email/email.php";
require_once "config.php";
require_once $root."/include/view/page/admin/usersIncludeFiles.php";
require_once $root."/include/view/views.php";
require_once $root."/include/model/ContactModel.php";
require_once $root."/include/etc/session.php";
siteSession();


function systemNotify($message)
{
    $contact                 = new Contact("");
    $contact->contactName    = $_SESSION['contactName'];
    $contact->contactEmail   = $_SESSION['contactEmail'];
    $contact->contactPhone   = $_SESSION['contactPhone'];
    $contact->contactCompany = $_SESSION['contactCompany'];
    $contact->contactSubject = $_SESSION['contactSubject'];
    $contact->contactMessage = $_SESSION['contactMessage'];

    $contact->contactCreated = sqlNow();
    $contact->contactModified= sqlNow();
    $contact->contactSource  = "SIGNUP";
    $contact->contactStatus  = "UNREAD";
    $contact->contactId      = null;

    $db = new ContactModel();
    $db->insert($contact);

    //-------------------------------------------
    // Send notification email to 
    // ThePeoplesJukebox.com admin
    //-------------------------------------------
    $admins = systemEmail();
    
    foreach($admins as $senderAdmin)
    {
        error_log($senderAdmin." sent\n", 0);
        $email = new Email();
        $textBody =$contact->contactName." signed up.";
        $email->senderName   = "ThePeoplesJukebox.com";
        $email->toEmail      = $senderAdmin;
        $email->toName       = "Sys Admin";
        $email->subject      = $message;
        $email->body         = viewSystemEventEmail($textBody);
    
        $email->send();
    }
}
?>
