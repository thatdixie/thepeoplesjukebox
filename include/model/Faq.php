<?php
require_once "DBObject.php";

/********************************************
 * Faq represents a table in jukeboxDB 
 *
 * @author  megan
 * @version 180927
 ********************************************
 */
class Faq extends DBObject
{    
    public $faqId=0;
    public $faqQuestion="";
    public $faqAnswer="";
    public $faqOrder=0;
    public $faqCreated="";
    public $faqModified="";
    public $faqStatus="";



    /*****************************************************
     * Returns an HTTP parameter list for Faq object
     *
     * @return
     *****************************************************
     */
    public function makeHTTPParameters()
    {    
        $b ="&";
        $b.="faqId=".$this->faqId."&";
        $b.="faqQuestion=".$this->faqQuestion."&";
        $b.="faqAnswer=".$this->faqAnswer."&";
        $b.="faqOrder=".$this->faqOrder."&";
        $b.="faqCreated=".$this->faqCreated."&";
        $b.="faqModified=".$this->faqModified."&";
        $b.="faqStatus=".$this->faqStatus."&";
        return($b);


    }

    /**************************************************************
     * Returns a JSON encoded representation of the Faq object
     *
     * @return JSON
     **************************************************************
     */
    public function makeJSON()
    {
        return(json_encode($this));
    }

    /******************************************************
     * Construct a Faq from a JSONObject.
     *
     * @param json
     *        A JSONObject.
     ******************************************************
     */
    function Faq($jsonString='')
    {
        //--------------------------------------------------------------------
        // I'm basically OK with being quiet on missing JSON property names
        //--------------------------------------------------------------------
        error_reporting( error_reporting() & ~E_NOTICE );
        error_reporting( error_reporting() & ~E_WARNING );

        if($json = $this->getJSON($jsonString) )
        {        
        $this->faqId= $json['faqId'];
        $this->faqQuestion= $json['faqQuestion'];
        $this->faqAnswer= $json['faqAnswer'];
        $this->faqOrder= $json['faqOrder'];
        $this->faqCreated= $json['faqCreated'];
        $this->faqModified= $json['faqModified'];
        $this->faqStatus= $json['faqStatus'];

        }
    }
}

?>
