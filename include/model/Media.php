<?php
require_once "DBObject.php";

/********************************************
 * Media represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Media extends DBObject
{    
    public $mediaId=0;
    public $userId=0;
    public $mediaFile="";
    public $mediaSource="";
    public $mediaArtist="";
    public $mediaTitle="";
    public $mediaYear="";
    public $mediaDuration="";
    public $mediaCreated="";
    public $mediaModified="";
    public $mediaStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for Media object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="mediaId=".$this->mediaId."&";
        $b.="userId=".$this->userId."&";
        $b.="mediaFile=".$this->mediaFile."&";
        $b.="mediaSource=".$this->mediaSource."&";
        $b.="mediaArtist=".$this->mediaArtist."&";
        $b.="mediaTitle=".$this->mediaTitle."&";
        $b.="mediaYear=".$this->mediaYear."&";
        $b.="mediaDuration=".$this->mediaDuration."&";
        $b.="mediaCreated=".$this->mediaCreated."&";
        $b.="mediaModified=".$this->mediaModified."&";
        $b.="mediaStatus=".$this->mediaStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Media object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Media from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Media($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->mediaId= $json['mediaId'];
        $this->userId= $json['userId'];
        $this->mediaFile= $json['mediaFile'];
        $this->mediaSource= $json['mediaSource'];
        $this->mediaArtist= $json['mediaArtist'];
        $this->mediaTitle= $json['mediaTitle'];
        $this->mediaYear= $json['mediaYear'];
        $this->mediaDuration= $json['mediaDuration'];
        $this->mediaCreated= $json['mediaCreated'];
        $this->mediaModified= $json['mediaModified'];
        $this->mediaStatus= $json['mediaStatus'];

        }
    }
}

?>
