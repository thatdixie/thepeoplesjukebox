<?php
//-------------------------------------------------------------
// load login page or user landing page
//-------------------------------------------------------------
require_once "../include/view/page/admin/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/controller/admin/admin.php";
siteSession();

if(isAdminLoginOK())
{
    if(getRequest("func") =="logout")
    {
        adminLogout();
        redirect("/login/");
    }
    else
    {
        findUserHomePage();
    }
}
else
{
    //---------------------------------------
    // We're not logged-in show login screen
    //---------------------------------------
    login();
}
?>
