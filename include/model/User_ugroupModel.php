<?php
require_once "JukeboxDB.php";
require      "User_ugroup.php";

/********************************************************************
 * User_ugroupModel inherits JukeboxDB and provides functions to
 * map User_ugroup class to jukeboxDB.
 *
 * @author  megan
 * @version 180906
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
}
?>    