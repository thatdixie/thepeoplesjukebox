<?php
require_once "DBObject.php";

/********************************************
 * Ugroup represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Ugroup extends DBObject
{    
    public $ugroupId=0;
    public $ugroupName="";



    /*****************************************************
     * Returns an HTTP parameter list for Ugroup object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="ugroupId=".$this->ugroupId."&";
        $b.="ugroupName=".$this->ugroupName."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Ugroup object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Ugroup from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Ugroup($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->ugroupId= $json['ugroupId'];
        $this->ugroupName= $json['ugroupName'];

        }
    }
}

?>
