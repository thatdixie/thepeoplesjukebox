<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/sql.php";
require_once $root."/include/etc/config.php";
require_once "JukeboxDB.php";
require_once "PlaylistModel.php";
require_once "Playlist.php";
require_once "Media.php";

/********************************************************************
 * UserPlaylistModel inherits PlaylistModel 
 *
 *
 * @author  dixie
 *********************************************************************
 */
class UserPlaylistModel extends PlaylistModel
{
    /*********************************************************
     * Returns Playlist for a jukebox
     *
     * @param  int  - $id
     * @return array  $playlists
     *********************************************************
     */
    public function findNextInQueue($id)
    {
        $playlist = array();
        
        $pl = $this->findUserPlayList($id);
        $c  = count($pl);
        if($c > 1)
        {
            $this->delete($pl[0]->playlistId);
            
            for($i=1; $i<$c; $i++ )
            {
                $playlist[$i-1] = $pl[$i];
                $playlist[$i-1]->playlistOrder = $i;
            }
            $playlist[0]->playlistModified= sqlNow();;
            $playlist[0]->playlistStatus  = 'PLAYING';
            $this->updateUserPlaylist($playlist);
        }
        else if($c ==1)
        {
            $medias = $this->getJukeboxCatalog($id);
            $rand   = mt_rand(0, count($medias) - 1);
            $playlist[0]                = $pl[0];
            $playlist[0]->playlistOrder = 1;
            $playlist[0]->mediaId       = $medias[$rand]->mediaId;
            $playlist[0]->userId        = $id;
            $playlist[0]->playlistUserId= $id;
            $playlist[0]->playlistModified= sqlNow();;
            $playlist[0]->playlistStatus  = 'PLAYING';
            $this->update($playlist[0]);   
        }
        else
        {
            $medias = $this->getJukeboxCatalog($id);
            $rand   = mt_rand(0, count($medias) - 1);
            $playlist[0]->playlistOrder   = 1;
            $playlist[0]->mediaId         = $medias[$rand]->mediaId;
            $playlist[0]->userId          = $id;
            $playlist[0]->playlistUserId  = $id;
            $playlist[0]->playlistCreated = sqlNow();;
            $playlist[0]->playlistModified= sqlNow();;
            $playlist[0]->playlistStatus  = 'PLAYING';
            $this->insert($playlist[0]);
        }
        
        return($this->getCurrentlyPlaying($id));
    }

    /*********************************************************
     * Returns Playlist for a jukebox
     *
     * @param  int  - $id
     * @return array  $playlists
     *********************************************************
     */
    public function findUserPlaylist($id)
    {
        $query="SELECT playlistId,".
                      "userId,".
                      "mediaId,".
                      "playlistUserId,".
                      "playlistOrder,".
                      "playlistCreated,".
                      "playlistModified,".
                      "playlistStatus ".                      		               
	       "FROM playlist ".
           "WHERE (playlistStatus='QUEUE' OR playlistStatus='PLAYING') ".
           "AND userId=".$id." ORDER by playlistOrder";

        return($this->selectDB($query, "Playlist"));
    }

    
    /*********************************************************
     * update User Playlist 
     *
     * @param array playlists
     *********************************************************
     */
    public function updateUserPlaylist($playlists)
    {
        $query= " UPDATE playlist SET ";

        $col = "userId = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN  ".$playlist->userId." ";
        $col.="ELSE userId END, ";
        $query.=$col; 
        
        $col = "mediaId = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN  ".$playlist->mediaId." ";
        $col.="ELSE mediaId END, ";
        $query.=$col;

        $col = "playlistUserId = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN  ".$playlist->playlistUserId." ";
        $col.="ELSE playlistUserId END, ";
        $query.=$col;

        $col = "playlistStatus = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN '".$this->sqlSafe($playlist->playlistStatus)."' ";
        $col.="ELSE playlistStatus END, ";
        $query.=$col;
        
        $col = "playlistOrder = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN ".$playlist->playlistOrder." ";
        $col.="ELSE playlistOrder END, ";
        $query.=$col;

        $col = "playlistModified = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN '".$this->sqlSafe($playlist->playlistModified)."' ";
        $col.="ELSE playlistModified END ";
        $query.=$col;
                
	    $where= "WHERE ";
        foreach($playlists as $playlist)
            $where.="playlistId=".$playlist->playlistId." OR ";
        $where.="playlistId=0";
        $query.=$where;

        //error_log($query,0);
        $this->executeQuery($query);
    }

    /*********************************************************
     * Returns a Media by userId (it's the jukebox catalog)
     *
     * @return media
     *********************************************************
     */
    public function getJukeboxCatalog($id)
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
     * Returns a Media by userId (jukebox) 
     * that's currently playing -- joins playlist
     *
     * @return media
     *********************************************************
     */
    public function getCurrentlyPlaying($id)
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
}

?>