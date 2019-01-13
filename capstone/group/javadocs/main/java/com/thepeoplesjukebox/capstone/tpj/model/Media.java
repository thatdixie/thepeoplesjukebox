package com.thepeoplesjukebox.capstone.tpj.model;

import com.thepeoplesjukebox.capstone.json.JSONObject;

/**
 * Value Object for Media using TPJ API 
 *
 * @author  Dixie
 */
public class Media extends Object
{

    public int    mediaId       =0;
    public int    userId        =0;
    public String mediaFile     ="";
    public String mediaSource   ="";
    public String mediaArtist   ="";
    public String mediaTitle    ="";
    public String mediaYear     ="";
    public String mediaDuration ="";
    public String mediaCreated  ="";
    public String mediaModified ="";
    public String mediaStatus   ="";
    
    /**
     * Construct a Media from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public Media(JSONObject json)
    {
        mediaId       = json.getInt("mediaId");
        userId        = json.getInt("userId");
        mediaFile     = json.getString("mediaFile");
        mediaSource   = json.getString("mediaSource");
        mediaArtist   = json.getString("mediaArtist");
        mediaTitle    = json.getString("mediaTitle");
        mediaYear     = json.getString("mediaYear");
        mediaDuration = json.getString("mediaDuration");
        mediaCreated  = json.getString("mediaCreated");
        mediaModified = json.getString("mediaModified");
        mediaStatus   = json.getString("mediaStatus");
    }

    public Media()
    {

    }
}
