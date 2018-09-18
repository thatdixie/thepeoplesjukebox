<?php
require_once "DBObject.php";

/********************************************
 * DownloadReport represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180906
 ********************************************
 */
class DownloadReport extends DBObject
{    
    public $downloadOs="";
    public $downloadBrowser="";
    public $softwareVersion="";
    public $count=0;



    /*****************************************************
     * Returns an HTTP parameter list for DownloadReport object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="downloadOs=".$this->downloadOs."&";
        $b.="downloadBrowser=".$this->downloadBrowser."&";
        $b.="softwareVersion=".$this->softwareVersion."&";
        $b.="count=".$this->count."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the DownloadReport object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a DownloadReport from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function DownloadReport($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->downloadOs= $json['downloadOs'];
        $this->downloadBrowser= $json['downloadBrowser'];
        $this->softwareVersion= $json['softwareVersion'];
        $this->count= $json['count'];

        }
    }
}

?>
