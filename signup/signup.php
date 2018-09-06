<?php

//**********************************************************
// This is a TEMP signup STUB that uses CAPTCHA
// TODO: Actual signup and not just a contact insertion.
//**********************************************************

require_once "../include/etc/session.php";
siteSession();

if(isCaptchaOK())
{
    //------------------------------
    // CAPTCHA validated...
    //------------------------------
    require "../include/etc/sql.php";
    require "../include/view/views.php";
    require "../include/model/ContactModel.php";

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
    require_once "../include/etc/email/email.php";
    require_once "../include/etc/config.php";
    require_once "../include/view/page/admin/usersIncludeFiles.php";

    $email = new Email();
    $textBody =$contact->contactName." signed up.";
    $email->senderName   = "ThePeoplesJukebox.com";
    $email->toEmail      = systemEmail();
    $email->toName       = "Sys Admin";
    $email->subject      = "There was a signup";
    $email->body         = viewSystemEventEmail($textBody);
    
    $email->send();
    
   kissyface("Thank You!", "/user/");
}
else
{
    //--------------------------------------------------
    // CAPTCHA not validated yet...
    //--------------------------------------------------
    require "../include/view/page/captcha/indexIncludeFiles.php";
    $_SESSION['contactName']    = $_REQUEST['name'];
    $_SESSION['contactEmail']   = $_REQUEST['email'];
    $_SESSION['contactPhone']   = $_REQUEST['phone'];
    $_SESSION['contactSubject'] = "Signup";
    $_SESSION['contactMessage'] = "http://ThePeoplesJukebox.com";

    //-----------------------------------------------------
    // set this page as redirect after successful CAPTCHA
    //-----------------------------------------------------
    $_SESSION['captchaPage']    = "/signup/signup.php";

    //--------------------------------
    // This is the captcha page...
    //--------------------------------
    redirect("/captcha/getcaptcha.php"); 
}
?>


