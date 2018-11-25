<?php
require_once "JukeboxDB.php";
require      "MediaModel.php";


/********************************************************************
 * UserMediaModel inherits MediaModel and provides functions to
 * map User Media data. 
 *
 * @author  megan
 * @version 181124
 *********************************************************************
 */
class UserMediaModel extends MediaModel
{
    /*********************************************************
     * Returns a Media by userId (it's the jukebox catalog)
     *
     * @param  $id
     * @return $medias
     *********************************************************
     */
    public function findByUserId($id)
    {
        $query="SELECT media.mediaId,".
                      "media.userId,".
                      "media.mediaFile,".
                      "media.mediaSource,".
                      "media.mediaArtist,".
                      "media.mediaTitle,".
                      "media.mediaYear,".
                      "media.mediaDuration,".
                      "media.mediaCreated,".
                      "media.mediaModified,".
                      "media.mediaStatus ".                      		               
	       "FROM media, upload ".
           "WHERE media.mediaStatus='ACTIVE' ".
             "AND media.userId=upload.userId ".
             "AND upload.uploadStatus='COMPLETE' ".
             "AND media.userId=".$id;

        $medias = $this->selectDB($query, "Media");
        if(count($medias) == 0)
        {
            $medias[0] = new Media();
            $medias[0]->mediaStatus="Upload in Progress";
        }
        return($medias);
    }


    /*********************************************************
     * find media by search 
     *
     * @param  int    -- $id
     * @param  string -- $key
     * @return media
     *********************************************************
     */
    public function findBySearchKey($id, $key)
    {
        if(blacklistSafe($key) != "")
        {
            $search = " AND (mediaArtist COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR  mediaTitle  COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' )";
        }
        else
        {
            $search = " ";
        }

        $query="SELECT media.mediaId,".
                      "media.userId,".
                      "media.mediaFile,".
                      "media.mediaSource,".
                      "media.mediaArtist,".
                      "media.mediaTitle,".
                      "media.mediaYear,".
                      "media.mediaDuration,".
                      "media.mediaCreated,".
                      "media.mediaModified,".
                      "media.mediaStatus ".           		               
	       "FROM media, upload ".
           "WHERE mediaStatus='ACTIVE' ".
             "AND media.userId=upload.userId ".
             "AND upload.uploadStatus='COMPLETE' ".      
             "AND media.userId=".$id." ".$search;

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
                      "media.mediaSource,".
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
                      "media.mediaSource,".
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
           "AND playlist.userId=".$id." ORDER BY playlist.playlistOrder";

        return($this->selectDB($query, "Media"));
    }
}

?>