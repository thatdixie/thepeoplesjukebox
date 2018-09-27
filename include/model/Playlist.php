<?php
require_once "DBObject.php";

/********************************************
 * Playlist represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Playlist extends DBObject
{    
    public $playlistId=0;
    public $userId=0;
    public $mediaId=0;
    public $playlistUserId=0;
    public $playlistOrder=0;
    public $playlistCreated="";
    public $playlistModified="";
    public $playlistStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for Playlist object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="playlistId=".$this->playlistId."&";
        $b.="userId=".$this->userId."&";
        $b.="mediaId=".$this->mediaId."&";
        $b.="playlistUserId=".$this->playlistUserId."&";
        $b.="playlistOrder=".$this->playlistOrder."&";
        $b.="playlistCreated=".$this->playlistCreated."&";
        $b.="playlistModified=".$this->playlistModified."&";
        $b.="playlistStatus=".$this->playlistStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Playlist object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Playlist from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Playlist($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->playlistId= $json['playlistId'];
        $this->userId= $json['userId'];
        $this->mediaId= $json['mediaId'];
        $this->playlistUserId= $json['playlistUserId'];
        $this->playlistOrder= $json['playlistOrder'];
        $this->playlistCreated= $json['playlistCreated'];
        $this->playlistModified= $json['playlistModified'];
        $this->playlistStatus= $json['playlistStatus'];

        }
    }
}

?>
