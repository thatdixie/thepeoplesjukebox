<?php
require_once "DBObject.php";

/********************************************
 * Permission represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Permission extends DBObject
{    
    public $permissionId=0;
    public $permissionName="";



    /*****************************************************
     * Returns an HTTP parameter list for Permission object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="permissionId=".$this->permissionId."&";
        $b.="permissionName=".$this->permissionName."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Permission object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Permission from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Permission($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->permissionId= $json['permissionId'];
        $this->permissionName= $json['permissionName'];

        }
    }
}

?>
