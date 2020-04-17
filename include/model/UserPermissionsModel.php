<?php
require_once "JukeboxDB.php";
require_once "PermissionModel.php";
require_once "Permission.php";
require_once "User.php";

/********************************************************************
 * UserPermissionsModel inherits PermissionModel 
 * and provides function to return user permissions
 *
 * @author  mgill
 * @version 180626
 *********************************************************************
 */
class UserPermissionsModel extends PermissionModel
{
    /*********************************************************
     * Returns a Permissions for User by userId
     *
     * @param  int  $userId 
     * @return array permission
     *********************************************************
     */
    public function findUserPermissions($userId)
    {
        $query = <<<EOF

        SELECT DISTINCT
	        permission.permissionName, permission.permissionId
        FROM
	        permission,
	        ugroup,user,
	        ugroup_permission,
            user_ugroup 
        WHERE
    	    ugroup_permission.ugroupId = ugroup.ugroupId
	    AND ugroup_permission.permissionId = permission.permissionId
	    AND user_ugroup.ugroupId = ugroup.ugroupId
	    AND user_ugroup.userId ={$userId}
EOF;

        return($this->selectDB($query, "Permission"));
    }
}
?>
