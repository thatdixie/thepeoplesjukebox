package com.thepeoplesjukebox.capstone.tpj.model;

import java.lang.*;
import com.thepeoplesjukebox.capstone.json.*;

/**
 * Value Object for Playlist using TPJ API 
 *
 * @author  Dixie
 */
public class Playlist extends Object
{

    public int    playlistId      =0;
    public int    userId          =0;
    public int    mediaId         =0;
    public int    playlistUserId  =0;
    public int    playlistOrder   =0;
    public String playlistCreated ="";
    public String playlistModified="";
    public String playlistStatus  ="";
    
    /**
     * Construct a Playlist from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public Playlist(JSONObject json)
    {
      //playlistId       = json.getInt("playlistId");
        userId           = json.getInt("userId");
        mediaId          = json.getInt("mediaId");
        playlistUserId   = json.getInt("playlistUserId");
        playlistOrder    = json.getInt("playlistOrder");
        playlistCreated  = json.getString("playlistCreated");
        playlistModified = json.getString("playlistModified");
        playlistStatus   = json.getString("playlistStatus");
    }

    public Playlist()
    {

    }
}
