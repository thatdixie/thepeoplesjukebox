<?php
require_once "EntityObjectsDB.php";
require      "Ugroup_permission.php";

/********************************************************************
 * Ugroup_permissionModel inherits EntityObjectsDB and provides functions to
 * map Ugroup_permission class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class Ugroup_permissionModel extends EntityObjectsDB
{
    /*********************************************************
     * Insert a new Ugroup_permission into entityobjectsDB database
     *
     * @param $ugroup_permission
     * @return n/a
     *********************************************************
     */
    public function insert($ugroup_permission)
    {
        $query="INSERT INTO ugroup_permission ( ".
                      "ugroupId,".
                      "permissionId ".                      
                           ")".
               "VALUES (".
                      " ".$ugroup_permission->ugroupId." ,".
                      " ".$ugroup_permission->permissionId."  ".                      
                     ")"; 

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Ugroup_permission by keys
     *
     * @param  $id
     * @param  $id2
     *
     * @return n/a
     *********************************************************
     */
    public function delete($id, $id2)
    {
        $query="DELETE FROM ugroup_permission WHERE ugroupId=".$id." AND permissionId=".$id2;

        $this->executeQuery($query);
    }

}
?>    