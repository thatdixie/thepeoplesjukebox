<?php
require_once "JukeboxDB.php";
require      "Ugroup_permission.php";

/********************************************************************
 * Ugroup_permissionModel inherits JukeboxDB and provides functions to
 * map Ugroup_permission class to jukeboxDB.
 *
 * @author  megan
 * @version 180927
 *********************************************************************
 */
class Ugroup_permissionModel extends JukeboxDB
{
    /*********************************************************
     * Insert a new Ugroup_permission into jukeboxDB database
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