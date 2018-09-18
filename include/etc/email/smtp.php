<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/PHPMailer/PHPMailer.php";
require_once $root."/include/etc/PHPMailer/SMTP.php";
require_once "email.php";

/**
 * Smtp  uses PHPMailer to send email to
 * a configured smtp server such as amazon SES or 
 * google g-suite. 
 *
 * @author  mgill
 *
 **/
class SmtpDiaper
{
    public $configUsername    = "";
    public $configPassword    = "";
    public $configHost        = "";
    public $configPort        = 0;
    public $configSecure      = true;
    public $configFromAddress = "";
    
    /**
     * Send an email 
     *
     * @param  class   $email
     * @return boolean true if failure 
     **/
    public function send($email)
    {
        $smtp = new PHPMailer();
        $smtp->isSMTP();
        $smtp->SMTPAuth   = true;
        $smtp->Username   = $this->configUsername;
        $smtp->Password   = $this->configPassword;
        $smtp->Host       = $this->configHost;
        $smtp->SMTPSecure = $this->configSecure;
        $smtp->Port       = $this->configPort;

        $smtp->setFrom($this->configFromAddress, $email->senderName);
        $smtp->addAddress($email->toEmail, $email->toName);
        $smtp->isHTML(true);
        $smtp->Subject = $email->subject;
        $smtp->Body    = $email->body; 
        $smtp->AltBody = $email->altBody;
        if(!$smtp->send())
        {
            $email->errorMessage = "Email not sent. , ".$smtp->ErrorInfo;
            error_log($email->errorMessage,0);
            return(true);
        }
        else
        {
            $email->errorMessage = "Email sent to ".$email->toEmail." OK";
            error_log($email->errorMessage,0);
            return(false);
        }
    }


    /**
     * SmtpDiaper construct from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     *
     **/
    function SmtpDiaper($json)
    {
        $r= json_decode($json, TRUE);
              
        $this->configUsername    = $r['configUsername'];
        $this->configPassword    = $r['configPassword'];
        $this->configHost        = $r['configHost'];
        $this->configPort        = $r['configPort'];
        $this->configSecure      = $r['configSecure'];
        $this->configFromAddress = $r['configFromAddress'];
    }
}

?>