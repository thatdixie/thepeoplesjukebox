<?php
require_once "DBConstants.php";

/********************************************************************
 * DBObject is the base class for Database Objects
 * This class contains error and status codes for DBObjects.
 *
 * @author  megan
 * @version 180927
 ********************************************************************
 */
class DBObject implements DBConstants  
{

    protected $dbErrors  = false;
    protected $errorString ="";
    protected $responseCode=0;
    protected $notifyFlag  = false;

    public function DBObject()
    {

    }

  /******************************************************************
   * returns true if DBObject has errors in being constructed 
   *
   * @return  boolean -- true or false
   ******************************************************************
   */
    public function hasErrors()
    {
	return($this->dbErrors);
    }

  /**********************************************************************
   * returns response code from server processing a JSON request
   * and contructing this object
   *
   * @return  int response code
   **********************************************************************
   */
    public function getResponseCode()
    {
        return($this->responseCode);
    }

  /**********************************************************************
   * returns error string from server processing a JSON request
   * and contructing this object
   *
   * @return  String - describing errors
   **********************************************************************
   */
    public function getErrorString()
    {
	return($this->errorString);
    }


  /******************************************************************
   * Sets the error flag for this object
   *
   * @param  flag - boolean error flag
   ******************************************************************
   */
    public function setErrors($flag)
    {
	$this->dbErrors = $flag;
    }

  /*****************************************************************
   * Sets the Server Response code for this object
   *
   * @param code -- server response code
   *****************************************************************
   */
    public function setResponseCode($code)
    {
	$this->responseCode = $code;
    }

  /*****************************************************************
   * Sets the Server Error String for this object
   *
   * @param err -- String describing error
   *****************************************************************
   */
    public function setErrorString($err)
    {
	$this->errorString = $err;
    }

  /**************************************************************************
   * checks to see if json response has error codes
   * then returns a $json object if valid or null if not
   *
   * @param  json string 
   * @return json object or null
   ***************************************************************************
   */
    public function getJSON($j)
    {
        $r = null;
        $this->setResponseCode(DBObject::RESPONSE_OK);

        if($j !="")
	{
	    $r = json_decode($j, TRUE);
            if(json_last_error() != JSON_ERROR_NONE)
	    {
    	        $this->setErrors(true);
	        $this->setErrorString(json_last_error_msg());
            }
	    else
	    {
                if(isset($r['status']) && isset($r['error']))
		{
	            $this->setResponseCode($r['status'] );
                    $this->setErrorString($r['error']);
                    $this->setErrors(true);
                    $r = null;
                }
            }
        }
        else
        {
    	    $this->setErrors(false);
	    $this->setErrorString("OK");
	}

        return($r);
    }

  /**
   * Sets the notify flag on for debugging 
   *
   */
    public function isDebug()
    {
      return($this->notifyFlag);
    }
  /**
   * Sets the notify flag on for debugging 
   *
   */
    public function setDebug()
    {
	$this->notifyFlag = true;
    }
  /**
   * ReSets the notify flag OFF for debugging 
   *
   */
    public function resetDebug()
    {
	$this->notifyFlag = false;
    }
}

?>
