<?php
//---------------------------------
// load /admin/users packages
//----------------------------------
require_once "../include/view/page/admin/usersIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

if(isAdminLoginOK() && hasPermission('canUserEdit'))
{
    switch(getRequest("func"))
    {
        case "disable":
        adminUserDisable(getRequest("id"));
        break;

        case "enable":
        adminUserEnable(getRequest("id"));
        break;

        case "delete_user":
        adminUserDelete(getRequest("id"));
        break;

        case "edit":
        adminUserEdit(getRequest("id"));
        break;

        case "update":
        adminUserUpdate(getRequest("id"));
        break;

        case "add_user_form":
        adminUserAddForm();
        break;

        case "add_user":
        adminUserAdd();
        break;

        case "reset_user":
        adminUserReset(getRequest("id"));
        break;

        case "add_group":
        adminUserAddGroup(getRequest("id"), getRequest("gid"));
        break;

        case "remove_group":
        adminUserRemoveGroup(getRequest("id"), getRequest("gid"));
        break;

        default:
        adminUsersPage();
        break;
    }
}
else
{
    redirect("/admin/");
}

//---------------------------------------
// Admin Users page
//---------------------------------------
function adminUsersPage()
{
    require_once "../include/model/UserLoginModel.php";

    $db       = new UserLoginModel();
    $userRows = $db->findAll();

    viewUsers($userRows);
}

//------------------------------------------
// Delete a user
//------------------------------------------
function adminUserDelete($id)
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/model/User_ugroupModel.php";

    //-------------------------------------------
    // find the user...
    //-------------------------------------------
    $db        = new UserLoginModel();
    $userRows  = $db->find($id);
    $user      = $userRows[0];
    //-------------------------------------------
    // delete user from any groups...
    //-------------------------------------------
    $userGroups= $db->findUserGroups($user->userId);
    $db2 = new User_ugroupModel();
    foreach($userGroups as $group)
        $db2->delete($user->userId, $group->ugroupId);
    //-------------------------------------------
    // delete user and go back to user list
    //-------------------------------------------
    $db->delete($user->userId);
    adminUsersPage();
}

//---------------------------------------
// Add a user form
//---------------------------------------
function adminUserAddForm()
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/etc/random.php";

    $db        = new UserLoginModel();
    $user      = new User();

    //-------------------------------------------------
    // Insert "info-stubs" ( i just made that up lol)
    // so that admin may edit with actual user data
    //-------------------------------------------------
    $user->accountId    = 1;
    $user->userName     = randomString(4)."@metaqueue.net";
    $user->userPassword = randomString(5);
    $user->userFirstName= "First Name";
    $user->userLastName = "Last Name";
    $user->userCreated  = sqlNow();
    $user->userModified = sqlNow();
    $user->userLastLogin= sqlNow();
    $user->userStatus   = "NEW";
    $user = $db->insert2($user);
    
    $userGroups= $db->findUserGroups($user->userId);
    $groups    = $db->findAllGroups();
    
    viewAddUser($user, $userGroups, $groups, $user->userPassword);
}

//---------------------------------------
// Add a user
//---------------------------------------
function adminUserAdd()
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/etc/email/email.php";

    $db        = new UserLoginModel();
    $user      = new User();

    //-------------------------------------------
    // Update with admin provided user info.
    //-------------------------------------------
    $user->userId       = getRequest("id");
    $user->userName     = getRequest("username");
    $user->userPassword = getRequest("login_code");
    $user->userFirstName= getRequest("first");
    $user->userLastName = getRequest("last");
    $user->userCreated  = sqlNow();
    $user->userModified = sqlNow();
    $user->userLastLogin= sqlNow();
    $user->userStatus   = "RESET";
    $user->accountId    = 1;
    $db->update($user);
    
    //-------------------------------------------
    // Invite user via email to active and
    // choose their password
    //-------------------------------------------
    $email = new Email();
    $email->senderName   = "metaQ.io Notifications";
    $email->toEmail      = $user->userName;
    $email->toName       = $user->userFirstName." ".$user->userLastName;
    $email->subject      = "Activate your login";
    $email->body         = viewUserActivateEmail($user, getRequest("login_code"));
    
    $email->send();
    adminUsersPage();
}

//---------------------------------------
// reset a user password
//---------------------------------------
function adminUserReset($id)
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/etc/random.php";
    require_once "../include/etc/email/email.php";

    //------------------------------------
    // Get user by $id...
    //------------------------------------
    $db       = new UserLoginModel();
    $userRows = $db->find($id);
    $row      = $userRows[0];

    //------------------------------------
    // put user record into RESET state
    //------------------------------------
    $resetCode         = randomString(5);
    $row->userPassword = $resetCode;
    $row->userStatus   = 'RESET';
    $row->userModified = sqlNow();
    $db->update($row);

    //-------------------------------------------
    // Invite user via email to change password
    //-------------------------------------------
    $email = new Email();
    $email->senderName   = "metaQ.io Notifications";
    $email->toEmail      = $row->userName;
    $email->toName       = $row->userFirstName." ".$row->userLastName;
    $email->subject      = "Password Reset";
    $email->body         = viewPasswordResetEmail($row, $resetCode);
    $email->send();

    //------------------------------------
    // Display users page...
    //------------------------------------
    adminUsersPage();
}

//---------------------------------------
// disable a user
//---------------------------------------
function adminUserDisable($id)
{
    require_once "../include/model/UserLoginModel.php";

    $db       = new UserLoginModel();
    $userRows = $db->find($id);
    $row      = $userRows[0];
    
    $row->userStatus  = 'SUS';
    $row->userModified= sqlNow();
    $db->update($row);

    adminUsersPage();
}

//---------------------------------------
// enable a user
//---------------------------------------
function adminUserEnable($id)
{
    require_once "../include/model/UserLoginModel.php";

    $db       = new UserLoginModel();
    $userRows = $db->find($id);
    $row      = $userRows[0];
    
    $row->userStatus  = 'ACTIVE';
    $row->userModified= sqlNow();
    $db->update($row);

    adminUsersPage();
}

//---------------------------------------
// edit a user
//---------------------------------------
function adminUserEdit($id)
{
    require_once "../include/model/UserLoginModel.php";

    $db        = new UserLoginModel();
    $userRows  = $db->find($id);
    $user      = $userRows[0];
    $userGroups= $db->findUserGroups($id);
    $groups    = $db->findAllGroups();
    
    viewEditUser($user, $userGroups, $groups);
}

//---------------------------------------
// edit a user add group
//---------------------------------------
function adminUserAddGroup($id, $gid)
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/model/User_ugroupModel.php";

    $db        = new UserLoginModel();
    $userRows  = $db->find($id);
    $user      = $userRows[0];
    $groups    = $db->findAllGroups();

    $db2 = new User_ugroupModel();
    $ug  = new User_ugroup();
    $ug->userId   = $id;
    $ug->ugroupId = $gid;
    $db2->insert($ug);

    $user->userModified = sqlNow();
    $db->update($user);
    
    $userGroups= $db->findUserGroups($id);
    
    if(getRequest("login_code"))
        viewAddUser($user, $userGroups, $groups, getRequest("login_code"));
    else
        viewEditUser($user, $userGroups, $groups);
}

//---------------------------------------
// edit a user remove group
//---------------------------------------
function adminUserRemoveGroup($id, $gid)
{
    require_once "../include/model/UserLoginModel.php";
    require_once "../include/model/User_ugroupModel.php";

    $db        = new UserLoginModel();
    $userRows  = $db->find($id);
    $user      = $userRows[0];
    $groups    = $db->findAllGroups();

    $db2 = new User_ugroupModel();
    $db2->delete($id, $gid);

    $user->userModified = sqlNow();
    $db->update($user);

    $userGroups= $db->findUserGroups($id);
    
    if(getRequest("login_code"))
        viewAddUser($user, $userGroups, $groups, getRequest("login_code"));
    else
        viewEditUser($user, $userGroups, $groups);
}


?>
