<?php
require_once "DBObject.php";

/********************************************
 * Download represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180906
 ********************************************
 */
class Download extends DBObject
{    
    public $downloadId=0;
    public $downloadUserAgent="";
    public $downloadOs="";
    public $downloadBrowser="";
    public $downloadVersion="";
    public $softwareId=0;
    public $contactEmail="";
    public $downloadCreated="";
    public $downloadModified="";
    public $downloadStatus="";
    public $downloadIpAddress="";



    /*****************************************************
     * Returns an HTTP parameter list for Download object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="downloadId=".$this->downloadId."&";
        $b.="downloadUserAgent=".$this->downloadUserAgent."&";
        $b.="downloadOs=".$this->downloadOs."&";
        $b.="downloadBrowser=".$this->downloadBrowser."&";
        $b.="downloadVersion=".$this->downloadVersion."&";
        $b.="softwareId=".$this->softwareId."&";
        $b.="contactEmail=".$this->contactEmail."&";
        $b.="downloadCreated=".$this->downloadCreated."&";
        $b.="downloadModified=".$this->downloadModified."&";
        $b.="downloadStatus=".$this->downloadStatus."&";
        $b.="downloadIpAddress=".$this->downloadIpAddress."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Download object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Download from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Download($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->downloadId= $json['downloadId'];
        $this->downloadUserAgent= $json['downloadUserAgent'];
        $this->downloadOs= $json['downloadOs'];
        $this->downloadBrowser= $json['downloadBrowser'];
        $this->downloadVersion= $json['downloadVersion'];
        $this->softwareId= $json['softwareId'];
        $this->contactEmail= $json['contactEmail'];
        $this->downloadCreated= $json['downloadCreated'];
        $this->downloadModified= $json['downloadModified'];
        $this->downloadStatus= $json['downloadStatus'];
        $this->downloadIpAddress= $json['downloadIpAddress'];

        }
    }
}

?>
