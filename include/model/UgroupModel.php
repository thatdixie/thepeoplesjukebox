<?php
require_once "EntityObjectsDB.php";
require      "Ugroup.php";

/********************************************************************
 * UgroupModel inherits EntityObjectsDB and provides functions to
 * map Ugroup class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class UgroupModel extends EntityObjectsDB
{
    /*********************************************************
     * Returns a Ugroup by ugroupId
     *
     * @return ugroup
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT ugroupId,".
                      "ugroupName ".                      		               
	       "FROM ugroup ".
	       "WHERE ugroupId=".$id;

        return($this->selectDB($query, "Ugroup"));
    }

    /*********************************************************
     * Insert a new Ugroup into entityobjectsDB database
     *
     * @param $ugroup
     * @return n/a
     *********************************************************
     */
    public function insert($ugroup)
    {
        $query="INSERT INTO ugroup ( ".
	              "ugroupId,".
                      "ugroupName ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($ugroup->ugroupName)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Ugroup into entityobjectsDB database
     * and return a Ugroup with new autoincrement
     * primary key
     *
     * @param  $ugroup
     * @return $ugroup
     *********************************************************
     */
    public function insert2($ugroup)
    {
        $query="INSERT INTO ugroup ( ".
	              "ugroupId,".
                      "ugroupName ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($ugroup->ugroupName)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $ugroup->ugroupId = $id;
	    return($ugroup);	
    }


    /*********************************************************
     * Update a Ugroup in entityobjectsDB database
     *
     * @param $ugroup
     * @return n/a
     *********************************************************
     */
    public function update($ugroup)
    {
        $query="UPDATE  ugroup ".
	          "SET ".
                      "ugroupId= ".$ugroup->ugroupId." ,".
                      "ugroupName='".$this->sqlSafe($ugroup->ugroupName)."' ".                      
	          "WHERE ugroupId=".$ugroup->ugroupId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Ugroup by ugroupId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM ugroup WHERE ugroupId=".$id;

        $this->executeQuery($query);
    }
}

?>