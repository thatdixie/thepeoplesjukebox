<?php
require_once "EntityObjectsDB.php";
require      "User_ugroup.php";

/********************************************************************
 * User_ugroupModel inherits EntityObjectsDB and provides functions to
 * map User_ugroup class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class User_ugroupModel extends EntityObjectsDB
{
    /*********************************************************
     * Insert a new User_ugroup into entityobjectsDB database
     *
     * @param $user_ugroup
     * @return n/a
     *********************************************************
     */
    public function insert($user_ugroup)
    {
        $query="INSERT INTO user_ugroup ( ".
                      "userId,".
                      "ugroupId ".                      
                           ")".
               "VALUES (".
                      " ".$user_ugroup->userId." ,".
                      " ".$user_ugroup->ugroupId."  ".                      
                     ")"; 

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a User_ugroup by keys
     *
     * @param  $id
     * @param  $id2
     *
     * @return n/a
     *********************************************************
     */
    public function delete($id, $id2)
    {
        $query="DELETE FROM user_ugroup WHERE userId=".$id." AND ugroupId=".$id2;

        $this->executeQuery($query);
    }

}
?>    