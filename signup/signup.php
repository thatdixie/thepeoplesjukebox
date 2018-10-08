<?php
/*******************************************
 * signup.php: 
 *
 * - user signup for thepeoplesjukebox.com
 * - uses CAPTCHA robot protection
 * - creates initial user profile and  
 * - redirects to user home page
 *
 * @author  Megan
 ********************************************
*/			
require_once "../include/etc/session.php";
siteSession();

if(isCaptchaOK())
{
    //------------------------------
    // CAPTCHA validated...
    //------------------------------
    require_once "../include/etc/notify.php";
    require_once "../include/etc/random.php";
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/model/User_ugroupModel.php";

    $db        = new UserLoginModel();
    $user      = new User();

    if($db->findByUserName(getUserSession("contactEmail")))
    {
        //------------------------------
        // User email already used...
        //------------------------------
        setCaptchaNOTOK();
        kissyface("Sorry! That email is already being used!", "/signup/");
        return;
    }
    
    //-------------------------------------------------
    // Insert "info-stubs" ( i just made that up lol)
    // that may fill in with actual user data later
    //-------------------------------------------------
    $user->userName     = getUserSession("contactEmail");
    $user->userFirstName= getUserSession("contactFirstName");
    $user->userLastName = getUserSession("contactLastName");
    $user->userPassword = randomString(5);
    $user->userCreated  = sqlNow();
    $user->userModified = sqlNow();
    $user->userLastLogin= sqlNow();
    $user->userStatus   = "NEW";
    $user->userIsJukebox= "NO";
    $user->accountId    = 1;
    $user->userId       = null;
    $user->userPasscode = "NO";
    $user->userNickName = "NO";
    $user->userLikes    = "NO";
    $user->userWorkplace= "NO";
    $user->userWorkHours= "NO";
    $user->userPhoto    = "NO";
    $user->userLongitude= "NO";
    $user->userLatitude = "NO";

    $user = $db->insert2($user);
        
    //---------------------------------------
    // Add user to 'jukeboxPlayer' group
    //---------------------------------------
    $db2 = new User_ugroupModel();
    $ug  = new User_ugroup();
    $ug->userId   = $user->userId;
    $ug->ugroupId = 4; //this is a 'jukeboxPlayer'
    $db2->insert($ug);
    
    //-------------------------------------------
    // Invite user via email to change password
    //-------------------------------------------
    $email = new Email();
    $email->senderName   = "ThePeoplesJukebox.com";
    $email->toEmail      = $user->userName;
    $email->toName       = $user->userFirstName." ".$user->userLastName;
    $email->subject      = "Activate your login";
    $email->body         = viewUserActivateEmail($user, $user->userPassword);
    $email->send();
    
    //---------------------------------
    // notify system administrators
    //---------------------------------
    systemNotify("There was a signup");

    //---------------------------------
    // send Thank you message and
    // redirect to user home page
    //---------------------------------
    setCaptchaNOTOK();
    kissyface("Thank You! Check Your Email!", "/");
}
else
{
    //--------------------------------------------------
    // CAPTCHA not validated yet...
    //--------------------------------------------------
    require "../include/view/page/captcha/indexIncludeFiles.php";

    setUserSession("contactFirstName", getRequest("first"));
    setUserSession("contactLastName" , getRequest("last"));
    setUserSession("contactEmail"    , getRequest("email"));
    setUserSession("contactSubject"  , "Signup");
    setUserSession("contactMessage"  , "http://ThePeoplesJukebox.com");

    //-----------------------------------------------------
    // set this page as redirect after successful CAPTCHA
    //-----------------------------------------------------
    setUserSession("captchaPage", "/signup/signup.php");

    //-------------------------------------
    // This is the captcha page.
    // User proves they are not a robot...
    //-------------------------------------
    redirect("/captcha/getcaptcha.php"); 
}
?>
