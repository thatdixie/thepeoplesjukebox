<?php
require_once "JukeboxDB.php";
require      "UploadModel.php";

/********************************************************************
 * UserUploadModel inherits UploadModel and provides functions to
 * map Upload class to jukeboxDB.
 *
 * @author  megan
 * @version 181124
 *********************************************************************
 */
class UserUploadModel extends UploadModel
{
    /*********************************************************
     * Returns a Upload by userId
     *
     * @param  $id
     * @return upload
     *********************************************************
     */
    public function findByUserId($id)
    {
        $query="SELECT uploadId,".
                      "userId,".
                      "uploadMetaData,".
                      "uploadSource,".
                      "uploadCreated,".
                      "uploadModified,".
                      "uploadStatus ".                      		               
	       "FROM upload ".
	       "WHERE userId=".$id;

        return($this->selectDB($query, "Upload"));
    }

}
?>