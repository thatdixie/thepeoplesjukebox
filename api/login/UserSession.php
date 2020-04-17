<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root."/include/etc/session.php";
require_once $root."/include/etc/random.php";
require_once $root."/include/etc/config.php";
require_once $root."/include/etc/json.php";
require_once $root."/include/model/UserLoginModel.php";
require_once $root."/include/model/UserPermissionsModel.php";
require_once $root."/include/model/UserMediaModel.php";
require_once $root."/include/model/UserPlaylistModel.php";
require_once $root."/include/model/UserProfileModel.php";
require_once $root."/include/model/UserUploadModel.php";

/********************************************************************
 * UserSession is a class for TPJ API and provides functions to
 * Login and validates a user session via session key
 *
 * @author  dixie
 * @version 181008
 *********************************************************************
 */
class UserSession 
{
    /*********************************************************
     * API helper function to login and create userPasscode
     * 
     * @param string -- $username
     * @param string -- $password
     * 
     * @return class -- $user
     *********************************************************
     */
    public function login($username, $password)
    {

        if($username && $password)
        {
            $user   = null;
            $db     = new UserLoginModel();
    
            if(($user = $db->findUserLogin($username, $password)))
            {
                //-------------------------------------
                // Generate a passcode so that
                // future API requests may use
                // username/passcode
                //-------------------------------------
                $user->userPasscode = randomString(10);
                $db->update($user);

                return($user);
            }
        }
    }

    /*********************************************************
     * API helper function to get user based on open session
     *
     * @param string -- $username
     * @param string -- $passcode
     * 
     * @return class -- $user
     *********************************************************
     */
    public function getUserSession($username, $passcode)
    {

        if($username && $passcode)
        {
            $user   = null;
            $db     = new UserLoginModel();
    
            if(($user = $db->findByUserPasscode($username, $passcode)))
            {
                return($user);
            }
        }
    }

    /*********************************************************
     * API helper function to get user permissions
     *
     * @param string -- $username
     * @param string -- $passcode
     * 
     * @return class -- $permissions
     *********************************************************
     */
    public function getUserPermissions($username, $passcode)
    {
        if($username && $passcode)
        {
            $db     = new UserLoginModel();
    
            if(($user = $db->findByUserPasscode($username, $passcode)))
            {
                $db2= new UserPermissionsModel();
                return($db2->findUserPermissions($user[0]->userId));
            }
        }
    }   
}

?>
