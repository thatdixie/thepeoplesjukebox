<?php
require_once "DBObject.php";

/********************************************
 * Ugroup_permission represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Ugroup_permission extends DBObject
{    
    public $ugroupId=0;
    public $permissionId=0;



    /*****************************************************
     * Returns an HTTP parameter list for Ugroup_permission object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="ugroupId=".$this->ugroupId."&";
        $b.="permissionId=".$this->permissionId."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Ugroup_permission object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Ugroup_permission from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Ugroup_permission($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->ugroupId= $json['ugroupId'];
        $this->permissionId= $json['permissionId'];

        }
    }
}

?>
