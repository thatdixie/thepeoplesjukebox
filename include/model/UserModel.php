<?php
require_once "EntityObjectsDB.php";
require      "User.php";

/********************************************************************
 * UserModel inherits EntityObjectsDB and provides functions to
 * map User class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class UserModel extends EntityObjectsDB
{
    /*********************************************************
     * Returns a User by userId
     *
     * @return user
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT userId,".
                      "accountId,".
                      "userName,".
                      "userPassword,".
                      "userFirstName,".
                      "userLastName,".
                      "userLastLogin,".
                      "userCreated,".
                      "userModified,".
                      "userStatus ".                      		               
	       "FROM user ".
	       "WHERE userId=".$id;

        return($this->selectDB($query, "User"));
    }

    /*********************************************************
     * Insert a new User into entityobjectsDB database
     *
     * @param $user
     * @return n/a
     *********************************************************
     */
    public function insert($user)
    {
        $query="INSERT INTO user ( ".
	              "userId,".
                      "accountId,".
                      "userName,".
                      "userPassword,".
                      "userFirstName,".
                      "userLastName,".
                      "userLastLogin,".
                      "userCreated,".
                      "userModified,".
                      "userStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$user->accountId." ,".
                      "'".$this->sqlSafe($user->userName)."',".
                      "'".$this->sqlSafe($user->userPassword)."',".
                      "'".$this->sqlSafe($user->userFirstName)."',".
                      "'".$this->sqlSafe($user->userLastName)."',".
                      "'".$this->sqlSafe($user->userLastLogin)."',".
                      "'".$this->sqlSafe($user->userCreated)."',".
                      "'".$this->sqlSafe($user->userModified)."',".
                      "'".$this->sqlSafe($user->userStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new User into entityobjectsDB database
     * and return a User with new autoincrement
     * primary key
     *
     * @param  $user
     * @return $user
     *********************************************************
     */
    public function insert2($user)
    {
        $query="INSERT INTO user ( ".
	              "userId,".
                      "accountId,".
                      "userName,".
                      "userPassword,".
                      "userFirstName,".
                      "userLastName,".
                      "userLastLogin,".
                      "userCreated,".
                      "userModified,".
                      "userStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$user->accountId." ,".
                      "'".$this->sqlSafe($user->userName)."',".
                      "'".$this->sqlSafe($user->userPassword)."',".
                      "'".$this->sqlSafe($user->userFirstName)."',".
                      "'".$this->sqlSafe($user->userLastName)."',".
                      "'".$this->sqlSafe($user->userLastLogin)."',".
                      "'".$this->sqlSafe($user->userCreated)."',".
                      "'".$this->sqlSafe($user->userModified)."',".
                      "'".$this->sqlSafe($user->userStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $user->userId = $id;
	    return($user);	
    }


    /*********************************************************
     * Update a User in entityobjectsDB database
     *
     * @param $user
     * @return n/a
     *********************************************************
     */
    public function update($user)
    {
        $query="UPDATE  user ".
	          "SET ".
                      "userId= ".$user->userId." ,".
                      "accountId= ".$user->accountId." ,".
                      "userName='".$this->sqlSafe($user->userName)."',".
                      "userPassword='".$this->sqlSafe($user->userPassword)."',".
                      "userFirstName='".$this->sqlSafe($user->userFirstName)."',".
                      "userLastName='".$this->sqlSafe($user->userLastName)."',".
                      "userLastLogin='".$this->sqlSafe($user->userLastLogin)."',".
                      "userCreated='".$this->sqlSafe($user->userCreated)."',".
                      "userModified='".$this->sqlSafe($user->userModified)."',".
                      "userStatus='".$this->sqlSafe($user->userStatus)."' ".                      
	          "WHERE userId=".$user->userId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a User by userId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM user WHERE userId=".$id;

        $this->executeQuery($query);
    }
}

?>