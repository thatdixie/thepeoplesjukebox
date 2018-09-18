<?php

$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/config.php";
require_once "smtp.php";

/**
 * Email class uses dependency injection to send email via  
 * a configured smtp server such as amazon SES or 
 * google g-suite.
 *
 * @author  mgill
 *
 **/
class Email
{
    public $senderName   = "";
    public $toEmail      = "";
    public $toName       = "";
    public $subject      = "";
    public $body         = "";
    public $altBody      = "This email requires an HTML enabled viewer";
    public $errorMessage = "";
    
    /**
     * Send an email 
     *
     * @return boolean true if failure 
     **/
    public function send()
    {
        $json   = file_get_contents(smtpConfig());
        $mailer = new SmtpDiaper($json);

        if($mailer->send($this))
            return(true);
        else
            return(false);
    }

}

?>