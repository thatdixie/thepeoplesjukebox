<?php
require_once "DBObject.php";

/********************************************
 * User_ugroup represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class User_ugroup extends DBObject
{    
    public $userId=0;
    public $ugroupId=0;



    /*****************************************************
     * Returns an HTTP parameter list for User_ugroup object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="userId=".$this->userId."&";
        $b.="ugroupId=".$this->ugroupId."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the User_ugroup object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a User_ugroup from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function User_ugroup($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->userId= $json['userId'];
        $this->ugroupId= $json['ugroupId'];

        }
    }
}

?>
