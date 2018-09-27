<?php
require_once "DBObject.php";

/********************************************
 * Contact represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Contact extends DBObject
{    
    public $contactId=0;
    public $contactName="";
    public $contactEmail="";
    public $contactPhone="";
    public $contactCompany="";
    public $contactSubject="";
    public $contactMessage="";
    public $contactSource="";
    public $contactCreated="";
    public $contactModified="";
    public $contactStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for Contact object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="contactId=".$this->contactId."&";
        $b.="contactName=".$this->contactName."&";
        $b.="contactEmail=".$this->contactEmail."&";
        $b.="contactPhone=".$this->contactPhone."&";
        $b.="contactCompany=".$this->contactCompany."&";
        $b.="contactSubject=".$this->contactSubject."&";
        $b.="contactMessage=".$this->contactMessage."&";
        $b.="contactSource=".$this->contactSource."&";
        $b.="contactCreated=".$this->contactCreated."&";
        $b.="contactModified=".$this->contactModified."&";
        $b.="contactStatus=".$this->contactStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Contact object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Contact from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Contact($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->contactId= $json['contactId'];
        $this->contactName= $json['contactName'];
        $this->contactEmail= $json['contactEmail'];
        $this->contactPhone= $json['contactPhone'];
        $this->contactCompany= $json['contactCompany'];
        $this->contactSubject= $json['contactSubject'];
        $this->contactMessage= $json['contactMessage'];
        $this->contactSource= $json['contactSource'];
        $this->contactCreated= $json['contactCreated'];
        $this->contactModified= $json['contactModified'];
        $this->contactStatus= $json['contactStatus'];

        }
    }
}

?>
