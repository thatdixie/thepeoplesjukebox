<?php
//---------------------------------
// load admin/page
//----------------------------------
require_once "../include/view/page/admin/downloadIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/etc/sql.php";
siteSession();

if(isAdminLoginOK())
{
    reportPage();
}
else
{
    redirect("/admin/");
}

//---------------------------------------
// download report
//---------------------------------------
function reportPage()
{
    require_once "../include/model/DownloadReportModel.php";

    $db             = new DownloadReportModel();
    $downloadReport = $db->select();
    
    viewDownloadReport($downloadReport);
}


?>
