<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/config.php";
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

        return($this->getMedias($this->selectDB($query, "Media")));
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

        return($this->getMedias($this->selectDB($query, "Media")));
    }

    /*********************************************************
     * Returns a Media by userId (it's the jukebox catalog)
     * This will find ALL media both ACTIVE or INACTIVE 
     * used by processUpload.php and possibly others.
     *
     * @param  $id
     * @return $medias
     *********************************************************
     */
    public function findAllByUserId($id)
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
	       "FROM media WHERE media.userId=".$id;

        return($this->getMedias($this->selectDB($query, "Media")));
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

        return($this->getMedias($this->selectDB($query, "Media")));
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

        return($this->getMedias($this->selectDB($query, "Media")));
    }


    /*********************************************************
     * Insert an array of Media into jukeboxDB database
     * Used by processUpload.php and possibly others.
     *
     * @param $medias
     * @return n/a
     *********************************************************
     */
    public function insertArray($medias)
    {
        $insert="INSERT INTO media ( ".
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
                           ") ".
               "VALUES ";
               $values=" ";
               $i =0;
               $l =count($medias);
               foreach($medias as $media)
               {
                   $values.="(".
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
                   if(++$i != $l)
                       $values.=", ";
               }
               $this->executeQuery($insert." ".$values);
    }

    /*********************************************************
     * This function will create a default Media object
     * when the results of a media query count is 0
     *
     * @param  $medias
     * @return $medias
     *********************************************************
     */
    private function getMedias($medias)
    {
        if(count($medias) == 0)
        {
            $medias[0] = new Media();
            $medias[0]->mediaid     = 0;
            $medias[0]->mediaFile   = defaultMediaFile();
            $medias[0]->mediaArtist = defaultMediaArtist();
            $medias[0]->mediaTitle  = defaultMediaTitle();
            $medias[0]->mediaSource = "UPLOAD";            
            $medias[0]->mediaStatus = "Upload in Progress";
        }
        return($medias);
    }       
}
?>