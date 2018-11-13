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
                      "mediaSource,".
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
            "WHERE mediaStatus='ACTIVE' AND userId=".$id." ".$search;

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