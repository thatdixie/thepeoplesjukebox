<?php
require_once "JukeboxDB.php";
require      "DownloadReport.php";

/********************************************************************
 * DownloadReportModel inherits JukeboxDB and provides the select() 
 * function which maps the DownloadReport class/VIEW in jukeboxDB.
 *
 * @author  megan
 * @version 180906
 *********************************************************************
 */
class DownloadReportModel extends JukeboxDB
{
    /*********************************************************
     * Returns  DownloadReport VIEW
     *
     * @return downloadReport
     *********************************************************
     */
    public function select()
    {
        $query="SELECT ".
                      "downloadOs,".
                      "downloadBrowser,".
                      "softwareVersion,".
                      "count ".                      		               
	       "FROM downloadReport ";
        return($this->selectDB($query, "DownloadReport"));
    }
}

?>