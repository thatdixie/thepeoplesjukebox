<?php
require_once "JukeboxDB.php";
require      "Media.php";

/********************************************************************
 * MediaModel inherits JukeboxDB and provides functions to
 * map Media class to jukeboxDB.
 *
 * @author  megan
 * @version 180927
 *********************************************************************
 */
class MediaModel extends JukeboxDB
{
    /*********************************************************
     * Returns a Media by mediaId
     *
     * @return media
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT mediaId,".
                      "userId,".
                      "mediaFile,".
                      "mediaSource,".
                      "mediaArtist,".
                      "mediaTitle,".
                      "mediaYear,".
                      "mediaDuration,".
                      "mediaCreated,".
                      "mediaModified,".
                      "mediaStatus ".                      		               
	       "FROM media ".
	       "WHERE mediaId=".$id;

        return($this->selectDB($query, "Media"));
    }

    /*********************************************************
     * Insert a new Media into jukeboxDB database
     *
     * @param $media
     * @return n/a
     *********************************************************
     */
    public function insert($media)
    {
        $query="INSERT INTO media ( ".
	              "mediaId,".
                      "userId,".
                      "mediaFile,".
                      "mediaSource,".
                      "mediaArtist,".
                      "mediaTitle,".
                      "mediaYear,".
                      "mediaDuration,".
                      "mediaCreated,".
                      "mediaModified,".
                      "mediaStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$media->userId." ,".
                      "'".$this->sqlSafe($media->mediaFile)."',".
                      "'".$this->sqlSafe($media->mediaSource)."',".
                      "'".$this->sqlSafe($media->mediaArtist)."',".
                      "'".$this->sqlSafe($media->mediaTitle)."',".
                      "'".$this->sqlSafe($media->mediaYear)."',".
                      "'".$this->sqlSafe($media->mediaDuration)."',".
                      "'".$this->sqlSafe($media->mediaCreated)."',".
                      "'".$this->sqlSafe($media->mediaModified)."',".
                      "'".$this->sqlSafe($media->mediaStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Media into jukeboxDB database
     * and return a Media with new autoincrement
     * primary key
     *
     * @param  $media
     * @return $media
     *********************************************************
     */
    public function insert2($media)
    {
        $query="INSERT INTO media ( ".
	              "mediaId,".
                      "userId,".
                      "mediaFile,".
                      "mediaSource,".
                      "mediaArtist,".
                      "mediaTitle,".
                      "mediaYear,".
                      "mediaDuration,".
                      "mediaCreated,".
                      "mediaModified,".
                      "mediaStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$media->userId." ,".
                      "'".$this->sqlSafe($media->mediaFile)."',".
                      "'".$this->sqlSafe($media->mediaSource)."',".
                      "'".$this->sqlSafe($media->mediaArtist)."',".
                      "'".$this->sqlSafe($media->mediaTitle)."',".
                      "'".$this->sqlSafe($media->mediaYear)."',".
                      "'".$this->sqlSafe($media->mediaDuration)."',".
                      "'".$this->sqlSafe($media->mediaCreated)."',".
                      "'".$this->sqlSafe($media->mediaModified)."',".
                      "'".$this->sqlSafe($media->mediaStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $media->mediaId = $id;
	    return($media);	
    }


    /*********************************************************
     * Update a Media in jukeboxDB database
     *
     * @param $media
     * @return n/a
     *********************************************************
     */
    public function update($media)
    {
        $query="UPDATE  media ".
	          "SET ".
                      "mediaId= ".$media->mediaId." ,".
                      "userId= ".$media->userId." ,".
                      "mediaFile='".$this->sqlSafe($media->mediaFile)."',".
                      "mediaSource='".$this->sqlSafe($media->mediaSource)."',".
                      "mediaArtist='".$this->sqlSafe($media->mediaArtist)."',".
                      "mediaTitle='".$this->sqlSafe($media->mediaTitle)."',".
                      "mediaYear='".$this->sqlSafe($media->mediaYear)."',".
                      "mediaDuration='".$this->sqlSafe($media->mediaDuration)."',".
                      "mediaCreated='".$this->sqlSafe($media->mediaCreated)."',".
                      "mediaModified='".$this->sqlSafe($media->mediaModified)."',".
                      "mediaStatus='".$this->sqlSafe($media->mediaStatus)."' ".                      
	          "WHERE mediaId=".$media->mediaId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Media by mediaId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM media WHERE mediaId=".$id;

        $this->executeQuery($query);
    }
}

?>