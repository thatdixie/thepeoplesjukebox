<?php
require_once "JukeboxDB.php";
require      "Playlist.php";

/********************************************************************
 * PlaylistModel inherits JukeboxDB and provides functions to
 * map Playlist class to jukeboxDB.
 *
 * @author  megan
 * @version 180927
 *********************************************************************
 */
class PlaylistModel extends JukeboxDB
{
    /*********************************************************
     * Returns a Playlist by playlistId
     *
     * @return playlist
     *********************************************************
     */
    public function find($id)
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
	       "WHERE playlistId=".$id;

        return($this->selectDB($query, "Playlist"));
    }

    /*********************************************************
     * Insert a new Playlist into jukeboxDB database
     *
     * @param $playlist
     * @return n/a
     *********************************************************
     */
    public function insert($playlist)
    {
        $query="INSERT INTO playlist ( ".
	              "playlistId,".
                      "userId,".
                      "mediaId,".
                      "playlistUserId,".
                      "playlistOrder,".
                      "playlistCreated,".
                      "playlistModified,".
                      "playlistStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$playlist->userId." ,".
                      " ".$playlist->mediaId." ,".
                      " ".$playlist->playlistUserId." ,".
                      " ".$playlist->playlistOrder." ,".
                      "'".$this->sqlSafe($playlist->playlistCreated)."',".
                      "'".$this->sqlSafe($playlist->playlistModified)."',".
                      "'".$this->sqlSafe($playlist->playlistStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Playlist into jukeboxDB database
     * and return a Playlist with new autoincrement
     * primary key
     *
     * @param  $playlist
     * @return $playlist
     *********************************************************
     */
    public function insert2($playlist)
    {
        $query="INSERT INTO playlist ( ".
	              "playlistId,".
                      "userId,".
                      "mediaId,".
                      "playlistUserId,".
                      "playlistOrder,".
                      "playlistCreated,".
                      "playlistModified,".
                      "playlistStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      " ".$playlist->userId." ,".
                      " ".$playlist->mediaId." ,".
                      " ".$playlist->playlistUserId." ,".
                      " ".$playlist->playlistOrder." ,".
                      "'".$this->sqlSafe($playlist->playlistCreated)."',".
                      "'".$this->sqlSafe($playlist->playlistModified)."',".
                      "'".$this->sqlSafe($playlist->playlistStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $playlist->playlistId = $id;
	    return($playlist);	
    }


    /*********************************************************
     * Update a Playlist in jukeboxDB database
     *
     * @param $playlist
     * @return n/a
     *********************************************************
     */
    public function update($playlist)
    {
        $query="UPDATE  playlist ".
	          "SET ".
                      "playlistId= ".$playlist->playlistId." ,".
                      "userId= ".$playlist->userId." ,".
                      "mediaId= ".$playlist->mediaId." ,".
                      "playlistUserId= ".$playlist->playlistUserId." ,".
                      "playlistOrder= ".$playlist->playlistOrder." ,".
                      "playlistCreated='".$this->sqlSafe($playlist->playlistCreated)."',".
                      "playlistModified='".$this->sqlSafe($playlist->playlistModified)."',".
                      "playlistStatus='".$this->sqlSafe($playlist->playlistStatus)."' ".                      
	          "WHERE playlistId=".$playlist->playlistId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Playlist by playlistId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM playlist WHERE playlistId=".$id;

        $this->executeQuery($query);
    }
}

?>