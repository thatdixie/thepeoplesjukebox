<?php
require_once "DBObject.php";

/********************************************
 * User represents an apiUser 
 *
 * @author  megan
 ********************************************
 */
class ApiUser extends DBObject
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

}

?>
