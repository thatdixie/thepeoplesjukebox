<?php
require_once "DBObject.php";

/********************************************
 * GetAllSoftware represents a table in entityobjectsDB 
 *
 * @author  mgill
 * @version 180722
 ********************************************
 */
class GetAllSoftware extends DBObject
{    
    public $softwareId=0;
    public $softwareFileName="";
    public $softwareVersion="";
    public $softwarePayload="";
    public $softwareCreated="";
    public $softwareModified="";
    public $softwareStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for GetAllSoftware object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="softwareId=".$this->softwareId."&";
        $b.="softwareFileName=".$this->softwareFileName."&";
        $b.="softwareVersion=".$this->softwareVersion."&";
        $b.="softwarePayload=".$this->softwarePayload."&";
        $b.="softwareCreated=".$this->softwareCreated."&";
        $b.="softwareModified=".$this->softwareModified."&";
        $b.="softwareStatus=".$this->softwareStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the GetAllSoftware object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a GetAllSoftware from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function GetAllSoftware($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->softwareId= $json['softwareId'];
        $this->softwareFileName= $json['softwareFileName'];
        $this->softwareVersion= $json['softwareVersion'];
        $this->softwarePayload= $json['softwarePayload'];
        $this->softwareCreated= $json['softwareCreated'];
        $this->softwareModified= $json['softwareModified'];
        $this->softwareStatus= $json['softwareStatus'];

        }
    }
}

?>
