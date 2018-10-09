<?php
require_once "JukeboxDB.php";
require      "MediaModel.php";


/********************************************************************
 * UserMediaModel inherits MediaModel and provides functions to
 * map User Media data. 
 *
 * @author  megan
 * @version 181008
 *********************************************************************
 */
class UserMediaModel extends MediaModel
{
    /*********************************************************
     * Returns a Media by userId
     *
     * @return media
     *********************************************************
     */
    public function findByUserId($id)
    {
        $query="SELECT mediaId,".
                      "userId,".
                      "mediaFile,".
                      "mediaArtist,".
                      "mediaTitle,".
                      "mediaYear,".
                      "mediaDuration,".
                      "mediaCreated,".
                      "mediaModified,".
                      "mediaStatus ".                      		               
	       "FROM media ".
	       "WHERE mediaStatus='ACTIVE' AND userId=".$id;

        return($this->selectDB($query, "Media"));
    }
}

?>