<?php
//---------------------------------
// load admin/page
//----------------------------------
require_once "../include/view/page/admin/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/controller/admin/admin.php";
siteSession();

if(isAdminLoginOK())
{    
    $func  = getRequest('func');
    $id    = getRequest('id');
    
    if($func == "view_contact")
    {
        adminContact($id);
    }
    elseif($func =="mark_as_read")
    {
        markAsRead($id);
    }
    elseif($func =="mark_as_unread")
    {
        markAsUnread($id);        
    }
    elseif($func =="delete")
    {
        if(getRequest('confirm') =="yes")
            deleteContact($id);
        else
            deleteConfirm($id);
    }
    elseif($func =="findcontacts")
    {
            adminFindContacts();
    }
    elseif($func =="logout")
    {
        adminLogout();
        redirect("/login/");
    }
    elseif($func =="inbox" && isSiteAdmin())
    {
        //-----------------------------------------------------
        // OK, so we're logged-in as a site admin
        // ...Go to admin inbox
        //-----------------------------------------------------        
        require_once "../include/model/AdminContactModel.php";
        $db       = new AdminContactModel();
        $contacts = $db->findUnread();
        adminHome($contacts);
    }
    else
    {
        //----------------------------------------
        // We're logged in so find landing page...
        //----------------------------------------
        findUserHomePage();
    }
}
else
{
    //------------------------------------------
    // get username and password (if entered)
    //------------------------------------------
    $username = getRequest('username');
    $password = getRequest('password');

    if($username && $password)
    {
        //---------------------------------------
	    // Check username and password 
	    //---------------------------------------
	    if(adminLogin($username, $password))
            findUserHomePage();
        else
	        login();
    }
    else
    {
        //--------------------
        // Display login form
        //--------------------
        login();
    }
}


//---------------------------------------
// mark as read
//---------------------------------------
function markAsRead($id)
{
    require_once "../include/model/ContactModel.php";

    $db       = new ContactModel();
    $contacts = $db->find($id);
    $contact  = $contacts[0];

    $contact->contactStatus ='READ';
    $db->update($contact);

    adminContact($id);
}

//---------------------------------------
// mark as UNread
//---------------------------------------
function markAsUnread($id)
{
    require_once "../include/model/ContactModel.php";

    $db       = new ContactModel();
    $contacts = $db->find($id);
    $contact  = $contacts[0];

    $contact->contactStatus ='UNREAD';
    $db->update($contact);

    adminContact($id);
}

//---------------------------------------
// admin a contact page
//---------------------------------------
function adminContact($id)
{
    require_once "../include/model/ContactModel.php";

    $db       = new ContactModel();
    $contacts = $db->find($id);
    $contact  = $contacts[0];
    
    viewAdminContact($contact);
}


//---------------------------------------
// delete confirm
//---------------------------------------
function deleteConfirm($id)
{
    require_once "../include/model/ContactModel.php";

    $db       = new ContactModel();
    $contacts = $db->find($id);
    $contact  = $contacts[0];
    
    viewDeleteConfirm($contact);
}

//---------------------------------------
// delete contact
//---------------------------------------
function deleteContact($id)
{
    require_once "../include/model/ContactModel.php";

    $db = new ContactModel();
    $db->delete($id);

    //dbface("Contact Deleted", "/admin/");
    //----------------------------------------------
    // decided just going back to admin is good :-)
    //----------------------------------------------
    findUserHomePage();
}

//---------------------------------------
// find contacts by date/name/whatever...
//---------------------------------------
function adminFindContacts()
{
    require_once "../include/model/AdminContactModel.php";

    $search_key  = getRequest('search_key');

    $db       = new AdminContactModel();
    $contacts = $db->findBySearch($search_key);

    findContacts($contacts);
}

?>
