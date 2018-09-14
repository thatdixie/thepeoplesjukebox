<?php
require_once "JukeboxDB.php";
require      "Download.php";

/********************************************************************
 * DownloadModel inherits JukeboxDB and provides functions to
 * map Download class to jukeboxDB.
 *
 * @author  megan
 * @version 180906
 *********************************************************************
 */
class DownloadModel extends JukeboxDB
{
    /*********************************************************
     * Returns a Download by downloadId
     *
     * @return download
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT downloadId,".
                      "downloadUserAgent,".
                      "downloadOs,".
                      "downloadBrowser,".
                      "downloadVersion,".
                      "softwareId,".
                      "contactEmail,".
                      "downloadCreated,".
                      "downloadModified,".
                      "downloadStatus,".
                      "downloadIpAddress ".                      		               
	       "FROM download ".
	       "WHERE downloadId=".$id;

        return($this->selectDB($query, "Download"));
    }

    /*********************************************************
     * Insert a new Download into jukeboxDB database
     *
     * @param $download
     * @return n/a
     *********************************************************
     */
    public function insert($download)
    {
        $query="INSERT INTO download ( ".
	              "downloadId,".
                      "downloadUserAgent,".
                      "downloadOs,".
                      "downloadBrowser,".
                      "downloadVersion,".
                      "softwareId,".
                      "contactEmail,".
                      "downloadCreated,".
                      "downloadModified,".
                      "downloadStatus,".
                      "downloadIpAddress ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($download->downloadUserAgent)."',".
                      "'".$this->sqlSafe($download->downloadOs)."',".
                      "'".$this->sqlSafe($download->downloadBrowser)."',".
                      "'".$this->sqlSafe($download->downloadVersion)."',".
                      " ".$download->softwareId." ,".
                      "'".$this->sqlSafe($download->contactEmail)."',".
                      "'".$this->sqlSafe($download->downloadCreated)."',".
                      "'".$this->sqlSafe($download->downloadModified)."',".
                      "'".$this->sqlSafe($download->downloadStatus)."',".
                      "'".$this->sqlSafe($download->downloadIpAddress)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Download into jukeboxDB database
     * and return a Download with new autoincrement
     * primary key
     *
     * @param  $download
     * @return $download
     *********************************************************
     */
    public function insert2($download)
    {
        $query="INSERT INTO download ( ".
	              "downloadId,".
                      "downloadUserAgent,".
                      "downloadOs,".
                      "downloadBrowser,".
                      "downloadVersion,".
                      "softwareId,".
                      "contactEmail,".
                      "downloadCreated,".
                      "downloadModified,".
                      "downloadStatus,".
                      "downloadIpAddress ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($download->downloadUserAgent)."',".
                      "'".$this->sqlSafe($download->downloadOs)."',".
                      "'".$this->sqlSafe($download->downloadBrowser)."',".
                      "'".$this->sqlSafe($download->downloadVersion)."',".
                      " ".$download->softwareId." ,".
                      "'".$this->sqlSafe($download->contactEmail)."',".
                      "'".$this->sqlSafe($download->downloadCreated)."',".
                      "'".$this->sqlSafe($download->downloadModified)."',".
                      "'".$this->sqlSafe($download->downloadStatus)."',".
                      "'".$this->sqlSafe($download->downloadIpAddress)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $download->downloadId = $id;
	    return($download);	
    }


    /*********************************************************
     * Update a Download in jukeboxDB database
     *
     * @param $download
     * @return n/a
     *********************************************************
     */
    public function update($download)
    {
        $query="UPDATE  download ".
	          "SET ".
                      "downloadId= ".$download->downloadId." ,".
                      "downloadUserAgent='".$this->sqlSafe($download->downloadUserAgent)."',".
                      "downloadOs='".$this->sqlSafe($download->downloadOs)."',".
                      "downloadBrowser='".$this->sqlSafe($download->downloadBrowser)."',".
                      "downloadVersion='".$this->sqlSafe($download->downloadVersion)."',".
                      "softwareId= ".$download->softwareId." ,".
                      "contactEmail='".$this->sqlSafe($download->contactEmail)."',".
                      "downloadCreated='".$this->sqlSafe($download->downloadCreated)."',".
                      "downloadModified='".$this->sqlSafe($download->downloadModified)."',".
                      "downloadStatus='".$this->sqlSafe($download->downloadStatus)."',".
                      "downloadIpAddress='".$this->sqlSafe($download->downloadIpAddress)."' ".                      
	          "WHERE downloadId=".$download->downloadId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Download by downloadId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM download WHERE downloadId=".$id;

        $this->executeQuery($query);
    }
}

?>