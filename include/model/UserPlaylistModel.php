<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/sql.php";
require_once "JukeboxDB.php";
require_once "PlaylistModel.php";
require_once "Playlist.php";

/********************************************************************
 * AdminPlaylistModel inherits PlaylistModel 
 *
 *
 * @author  mgill
 *********************************************************************
 */
class AdminPlaylistModel extends PlaylistModel
{
    /*********************************************************
     * Returns All Playlist results
     *
     * @return array playlists
     *********************************************************
     */
    public function findAll()
    {
        $query="SELECT playlistId,".
                      "playlistQuestion,".
                      "playlistAnswer,".
                      "playlistOrder,".
                      "playlistCreated,".
                      "playlistModified,".
                      "playlistStatus ".                      		               
	       "FROM playlist ".
	       "WHERE playlistStatus='ACTIVE' ORDER by playlistOrder" ;

        return($this->selectDB($query, "Playlist"));
    }

    /*********************************************************
     * update All Playlist 
     *
     * @param array playlists
     *********************************************************
     */
    public function updateAll($playlists)
    {
        $query= " UPDATE playlist SET ";

        $col = "playlistQuestion = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN '".$this->sqlSafe($playlist->playlistQuestion)."' ";
        $col.="ELSE playlistQuestion END, ";
        $query.=$col; 
        
        $col = "playlistAnswer = CASE ";
        foreach($playlists as $playlist)
            $col.="WHEN playlistId=".$playlist->playlistId." THEN '".$this->sqlSafe($playlist->playlistAnswer)."' ";
        $col.="ELSE playlistAnswer END, ";
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
}

?>