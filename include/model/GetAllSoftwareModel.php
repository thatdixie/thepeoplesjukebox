<?php
require_once "EntityObjectsDB.php";
require      "GetAllSoftware.php";

/********************************************************************
 * GetAllSoftwareModel inherits EntityObjectsDB and provides the select() 
 * function which maps the GetAllSoftware class/VIEW in entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class GetAllSoftwareModel extends EntityObjectsDB
{
    /*********************************************************
     * Returns  GetAllSoftware VIEW
     *
     * @return getAllSoftware
     *********************************************************
     */
    public function select()
    {
        $query="SELECT ".
                      "softwareId,".
                      "softwareFileName,".
                      "softwareVersion,".
                      "softwarePayload,".
                      "softwareCreated,".
                      "softwareModified,".
                      "softwareStatus ".                      		               
	       "FROM getAllSoftware ";
        return($this->selectDB($query, "GetAllSoftware"));
    }
}

?>