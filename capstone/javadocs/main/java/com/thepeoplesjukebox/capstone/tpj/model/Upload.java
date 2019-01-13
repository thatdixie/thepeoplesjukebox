package com.thepeoplesjukebox.capstone.tpj.model;
import com.thepeoplesjukebox.capstone.json.JSONObject;

/**
 * Value Object for Upload using TPJ API
 *
 * @author  Dixie
 */
public class Upload extends Object
{
    public int    uploadId       =0;
    public int    userId         =0;
    public String uploadMetaData ="";
    public String uploadSource   ="";
    public String uploadCreated  ="";
    public String uploadModified ="";
    public String uploadStatus   ="";

    /**
     * Construct a Upload from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public Upload(JSONObject json)
    {
        uploadId       = json.getInt("uploadId");
        userId         = json.getInt("userId");
        uploadMetaData = json.getString("uploadMetaData");
        uploadSource   = json.getString("uploadSource");
        uploadCreated  = json.getString("uploadCreated");
        uploadModified = json.getString("uploadModified");
        uploadStatus   = json.getString("uploadStatus");
    }

    public Upload()
    {

    }
}

