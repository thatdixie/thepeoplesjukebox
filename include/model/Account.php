<?php
require_once "DBObject.php";

/********************************************
 * Account represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Account extends DBObject
{    
    public $accountId=0;
    public $accountCompany="";
    public $accountAddress="";
    public $accountCity="";
    public $accountState="";
    public $accountCountry="";
    public $accountPhone="";
    public $accountFax="";
    public $accountEmail="";
    public $accountContactName="";



    /*****************************************************
     * Returns an HTTP parameter list for Account object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="accountId=".$this->accountId."&";
        $b.="accountCompany=".$this->accountCompany."&";
        $b.="accountAddress=".$this->accountAddress."&";
        $b.="accountCity=".$this->accountCity."&";
        $b.="accountState=".$this->accountState."&";
        $b.="accountCountry=".$this->accountCountry."&";
        $b.="accountPhone=".$this->accountPhone."&";
        $b.="accountFax=".$this->accountFax."&";
        $b.="accountEmail=".$this->accountEmail."&";
        $b.="accountContactName=".$this->accountContactName."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Account object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Account from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Account($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->accountId= $json['accountId'];
        $this->accountCompany= $json['accountCompany'];
        $this->accountAddress= $json['accountAddress'];
        $this->accountCity= $json['accountCity'];
        $this->accountState= $json['accountState'];
        $this->accountCountry= $json['accountCountry'];
        $this->accountPhone= $json['accountPhone'];
        $this->accountFax= $json['accountFax'];
        $this->accountEmail= $json['accountEmail'];
        $this->accountContactName= $json['accountContactName'];

        }
    }
}

?>
