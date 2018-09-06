<?php
require_once "JukeboxDB.php";
require      "GetAllSoftware.php";

/********************************************************************
 * GetAllSoftwareModel inherits JukeboxDB and provides the select() 
 * function which maps the GetAllSoftware class/VIEW in jukeboxDB.
 *
 * @author  megan
 * @version 180906
 *********************************************************************
 */
class GetAllSoftwareModel extends JukeboxDB
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