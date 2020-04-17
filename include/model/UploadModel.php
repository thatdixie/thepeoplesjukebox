<?php
require_once "JukeboxDB.php";
require      "Upload.php";

/********************************************************************
 * UploadModel inherits JukeboxDB and provides functions to
 * map Upload class to jukeboxDB.
 *
 * @author  megan
 * @version 181124
 *********************************************************************
 */
class UploadModel extends JukeboxDB
{
    /*********************************************************
     * Returns a Upload by uploadId
     *
     * @return upload
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT uploadId,".
                      "userId,".
                      "uploadMetaData,".
                      "uploadSource,".
                      "uploadCreated,".
                      "uploadModified,".
                      "uploadStatus ".                      		               
	       "FROM upload ".
	       "WHERE uploadId=".$id;

        return($this->selectDB($query, "Upload"));
    }

    /*********************************************************
     * Insert a new Upload into jukeboxDB database
     *
     * @param $upload
     * @return n/a
     *********************************************************
     */
    public function insert($upload)
    {
        $query="INSERT INTO upload ( ".
	              "uploadId,".
                      "userId,".
                      "uploadMetaData,".
                      "uploadSource,".
                      "uploadCreated,".
                      "uploadModified,".
                      "uploadStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$upload->userId." ,".
                      "'".$this->sqlSafe($upload->uploadMetaData)."',".
                      "'".$this->sqlSafe($upload->uploadSource)."',".
                      "'".$this->sqlSafe($upload->uploadCreated)."',".
                      "'".$this->sqlSafe($upload->uploadModified)."',".
                      "'".$this->sqlSafe($upload->uploadStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Upload into jukeboxDB database
     * and return a Upload with new autoincrement
     * primary key
     *
     * @param  $upload
     * @return $upload
     *********************************************************
     */
    public function insert2($upload)
    {
        $query="INSERT INTO upload ( ".
	              "uploadId,".
                      "userId,".
                      "uploadMetaData,".
                      "uploadSource,".
                      "uploadCreated,".
                      "uploadModified,".
                      "uploadStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$upload->userId." ,".
                      "'".$this->sqlSafe($upload->uploadMetaData)."',".
                      "'".$this->sqlSafe($upload->uploadSource)."',".
                      "'".$this->sqlSafe($upload->uploadCreated)."',".
                      "'".$this->sqlSafe($upload->uploadModified)."',".
                      "'".$this->sqlSafe($upload->uploadStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $upload->uploadId = $id;
	    return($upload);	
    }


    /*********************************************************
     * Update a Upload in jukeboxDB database
     *
     * @param $upload
     * @return n/a
     *********************************************************
     */
    public function update($upload)
    {
        $query="UPDATE  upload ".
	          "SET ".
                      "uploadId= ".$upload->uploadId." ,".
                      "userId= ".$upload->userId." ,".
                      "uploadMetaData='".$this->sqlSafe($upload->uploadMetaData)."',".
                      "uploadSource='".$this->sqlSafe($upload->uploadSource)."',".
                      "uploadCreated='".$this->sqlSafe($upload->uploadCreated)."',".
                      "uploadModified='".$this->sqlSafe($upload->uploadModified)."',".
                      "uploadStatus='".$this->sqlSafe($upload->uploadStatus)."' ".                      
	          "WHERE uploadId=".$upload->uploadId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Upload by uploadId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM upload WHERE uploadId=".$id;

        $this->executeQuery($query);
    }
}

?>