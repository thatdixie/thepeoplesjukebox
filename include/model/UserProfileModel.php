<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/sql.php";
require_once "JukeboxDB.php";
require_once "UserModel.php";
require_once "UserMediaModel.php";

/********************************************************************
 * UserProfileModel inherits UserModel and provides functions to
 * map User class
 *
 * @author  megan
 * @version 181011
 *********************************************************************
 */
class UserProfileModel extends UserModel
{
    /*********************************************************
     * Find User by search
     *
     * @return user
     *********************************************************
     */
    public function findJukeboxBySearch($key)
    {        
        if(blacklistSafe($key) != "")
        {
            $where = "AND  (userName COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR userFirstName COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR userLastName  COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR userNickName  COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR userLikes     COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR userWorkplace COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' )";
        }
        else
        {
            $where = " ";
        }
          
        $query="SELECT userId,".
                      "accountId,".
                      "userName,".
                      "userPassword,".
                      "userPasscode,".
                      "userFirstName,".
                      "userLastName,".
                      "userIsJukebox,".
                      "userNickName,".
                      "userLikes,".
                      "userWorkplace,".
                      "userWorkHours,".
                      "userPhoto,".
                      "userLongitude,".
                      "userLatitude,".
                      "userLastLogin,".
                      "userCreated,".
                      "userModified,".
                      "userStatus ".                      		               
	       "FROM user ".
	       "WHERE userIsJukebox='YES' AND userStatus='ACTIVE' ".$where;

        return($this->selectDB($query, "User"));
    }

    /*********************************************************
     * Find Jukeboxs near me
     *
     * @param  $long float 
     * @param  $lat  float
     * @return JukeBoxProfile
     *********************************************************
     */
    public function findJukeboxNearMe($long=0, $lat=0)
    {
        $query="SELECT userId,".
                      "accountId,".
                      "userName,".
                      "userPassword,".
                      "userPasscode,".
                      "userFirstName,".
                      "userLastName,".
                      "userIsJukebox,".
                      "userNickName,".
                      "userLikes,".
                      "userWorkplace,".
                      "userWorkHours,".
                      "userPhoto,".
                      "userLongitude,".
                      "userLatitude,".
                      "userLastLogin,".
                      "userCreated,".
                      "userModified,".
                      "userStatus ".                      		               
	       "FROM user ".
	       "WHERE userIsJukebox='YES' AND userStatus='ACTIVE' AND userPhoto!='NO' LIMIT 7";
        
        $users = $this->selectDB($query, "User");
        $db    = new UserMediaModel();
    
        for($i=0; $i<count($users); $i++)
        {
            $media = $db->findCurrentlyPlaying($users[$i]->userId);
            $users[$i]->userStatus = $media[0]->mediaTitle." -- ".$media[0]->mediaArtist;
        }
        return($users);
    }
}

?>