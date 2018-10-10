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
     * Returns a Media by userId (it's the jukebox catalog)
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


    /*********************************************************
     * Returns a Media by userId (jukebox) 
     * that's currently playing -- joins playlist
     *
     * @return media
     *********************************************************
     */
    public function findCurrentlyPlaying($id)
    {
        $query="SELECT media.mediaId,".
                      "media.userId,".
                      "media.mediaFile,".
                      "media.mediaArtist,".
                      "media.mediaTitle,".
                      "media.mediaYear,".
                      "media.mediaDuration,".
                      "media.mediaCreated,".
                      "media.mediaModified,".
                      "media.mediaStatus ".                      		               
	       "FROM media, playlist ".
	       "WHERE playlist.playlistStatus='PLAYING' ".
           "AND media.mediaId=playlist.mediaId ".
           "AND media.userId=playlist.userId ".
           "AND playlist.userId=".$id;

        return($this->selectDB($query, "Media"));
    }


    /*********************************************************
     * Returns a Media by userId (jukebox) 
     * that's currently in QUEUE (including currently playing) 
     * -- joins playlist
     *
     * @return media
     *********************************************************
     */
    public function findPlayQueue($id)
    {
        $query="SELECT media.mediaId,".
                      "media.userId,".
                      "media.mediaFile,".
                      "media.mediaArtist,".
                      "media.mediaTitle,".
                      "media.mediaYear,".
                      "media.mediaDuration,".
                      "media.mediaCreated,".
                      "media.mediaModified,".
                      "media.mediaStatus ".
	       "FROM media, playlist ".
	       "WHERE (playlist.playlistStatus='PLAYING' OR playlist.playlistStatus='QUEUE') ".
           "AND media.mediaId=playlist.mediaId ".
           "AND media.userId=playlist.userId ".
           "AND playlist.userId=".$id;

        return($this->selectDB($query, "Media"));
    }

}

?>