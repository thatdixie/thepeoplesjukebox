<?php
require_once "JukeboxDB.php";
require      "Software.php";

/********************************************************************
 * SoftwareModel inherits JukeboxDB and provides functions to
 * map Software class to jukeboxDB.
 *
 * @author  megan
 * @version 180906
 *********************************************************************
 */
class SoftwareModel extends JukeboxDB
{
    /*********************************************************
     * Returns a Software by softwareId
     *
     * @return software
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT softwareId,".
                      "softwareFileName,".
                      "softwareVersion,".
                      "softwarePayload,".
                      "softwareCreated,".
                      "softwareModified,".
                      "softwareStatus ".                      		               
	       "FROM software ".
	       "WHERE softwareId=".$id;

        return($this->selectDB($query, "Software"));
    }

    /*********************************************************
     * Insert a new Software into jukeboxDB database
     *
     * @param $software
     * @return n/a
     *********************************************************
     */
    public function insert($software)
    {
        $query="INSERT INTO software ( ".
	              "softwareId,".
                      "softwareFileName,".
                      "softwareVersion,".
                      "softwarePayload,".
                      "softwareCreated,".
                      "softwareModified,".
                      "softwareStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($software->softwareFileName)."',".
                      "'".$this->sqlSafe($software->softwareVersion)."',".
                      "'".$this->sqlSafe($software->softwarePayload)."',".
                      "'".$this->sqlSafe($software->softwareCreated)."',".
                      "'".$this->sqlSafe($software->softwareModified)."',".
                      "'".$this->sqlSafe($software->softwareStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Software into jukeboxDB database
     * and return a Software with new autoincrement
     * primary key
     *
     * @param  $software
     * @return $software
     *********************************************************
     */
    public function insert2($software)
    {
        $query="INSERT INTO software ( ".
	              "softwareId,".
                      "softwareFileName,".
                      "softwareVersion,".
                      "softwarePayload,".
                      "softwareCreated,".
                      "softwareModified,".
                      "softwareStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($software->softwareFileName)."',".
                      "'".$this->sqlSafe($software->softwareVersion)."',".
                      "'".$this->sqlSafe($software->softwarePayload)."',".
                      "'".$this->sqlSafe($software->softwareCreated)."',".
                      "'".$this->sqlSafe($software->softwareModified)."',".
                      "'".$this->sqlSafe($software->softwareStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $software->softwareId = $id;
	    return($software);	
    }


    /*********************************************************
     * Update a Software in jukeboxDB database
     *
     * @param $software
     * @return n/a
     *********************************************************
     */
    public function update($software)
    {
        $query="UPDATE  software ".
	          "SET ".
                      "softwareId= ".$software->softwareId." ,".
                      "softwareFileName='".$this->sqlSafe($software->softwareFileName)."',".
                      "softwareVersion='".$this->sqlSafe($software->softwareVersion)."',".
                      "softwarePayload='".$this->sqlSafe($software->softwarePayload)."',".
                      "softwareCreated='".$this->sqlSafe($software->softwareCreated)."',".
                      "softwareModified='".$this->sqlSafe($software->softwareModified)."',".
                      "softwareStatus='".$this->sqlSafe($software->softwareStatus)."' ".                      
	          "WHERE softwareId=".$software->softwareId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Software by softwareId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM software WHERE softwareId=".$id;

        $this->executeQuery($query);
    }
}

?>