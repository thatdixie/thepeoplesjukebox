<?php
require_once "JukeboxDB.php";
require      "User_ugroup.php";

/********************************************************************
 * User_ugroupModel inherits JukeboxDB and provides functions to
 * map User_ugroup class to jukeboxDB.
 *
 * @author  megan
 * @version 180927
 *********************************************************************
 */
class User_ugroupModel extends JukeboxDB
{
    /*********************************************************
     * Insert a new User_ugroup into jukeboxDB database
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