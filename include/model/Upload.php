<?php
require_once "DBObject.php";

/********************************************
 * Upload represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 181124
 ********************************************
 */
class Upload extends DBObject
{    
    public $uploadId=0;
    public $userId=0;
    public $uploadMetaData="";
    public $uploadSource="";
    public $uploadCreated="";
    public $uploadModified="";
    public $uploadStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for Upload object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="uploadId=".$this->uploadId."&";
        $b.="userId=".$this->userId."&";
        $b.="uploadMetaData=".$this->uploadMetaData."&";
        $b.="uploadSource=".$this->uploadSource."&";
        $b.="uploadCreated=".$this->uploadCreated."&";
        $b.="uploadModified=".$this->uploadModified."&";
        $b.="uploadStatus=".$this->uploadStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Upload object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Upload from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Upload($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->uploadId= $json['uploadId'];
        $this->userId= $json['userId'];
        $this->uploadMetaData= $json['uploadMetaData'];
        $this->uploadSource= $json['uploadSource'];
        $this->uploadCreated= $json['uploadCreated'];
        $this->uploadModified= $json['uploadModified'];
        $this->uploadStatus= $json['uploadStatus'];

        }
    }
}

?>
