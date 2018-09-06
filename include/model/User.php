<?php
require_once "DBObject.php";

/********************************************
 * User represents a table in entityobjectsDB 
 *
 * @author  mgill
 * @version 180722
 ********************************************
 */
class User extends DBObject
{    
    public $userId=0;
    public $accountId=0;
    public $userName="";
    public $userPassword="";
    public $userFirstName="";
    public $userLastName="";
    public $userLastLogin="";
    public $userCreated="";
    public $userModified="";
    public $userStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for User object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="userId=".$this->userId."&";
        $b.="accountId=".$this->accountId."&";
        $b.="userName=".$this->userName."&";
        $b.="userPassword=".$this->userPassword."&";
        $b.="userFirstName=".$this->userFirstName."&";
        $b.="userLastName=".$this->userLastName."&";
        $b.="userLastLogin=".$this->userLastLogin."&";
        $b.="userCreated=".$this->userCreated."&";
        $b.="userModified=".$this->userModified."&";
        $b.="userStatus=".$this->userStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the User object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a User from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function User($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->userId= $json['userId'];
        $this->accountId= $json['accountId'];
        $this->userName= $json['userName'];
        $this->userPassword= $json['userPassword'];
        $this->userFirstName= $json['userFirstName'];
        $this->userLastName= $json['userLastName'];
        $this->userLastLogin= $json['userLastLogin'];
        $this->userCreated= $json['userCreated'];
        $this->userModified= $json['userModified'];
        $this->userStatus= $json['userStatus'];

        }
    }
}

?>
