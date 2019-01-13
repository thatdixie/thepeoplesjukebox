package com.thepeoplesjukebox.capstone.tpj.model;

import java.lang.*;
import com.thepeoplesjukebox.capstone.json.*;

/**
 * Value Object for UserProfile using TPJ API 
 *
 * @author  Dixie
 */
public class UserProfile extends Object
{

    public String firstName ="";
    public String lastName  ="";
    public String nickName  ="";
    public String likes     ="";
    public String workplace ="";
    public String workhours ="";
    public String longitude ="";
    public String latitude  ="";

    
    /**
     * Construct a UserProfile from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public UserProfile(JSONObject json)
    {
        firstName = json.getString("firstName");
        lastName  = json.getString("lastName");
        nickName  = json.getString("nickName");
        likes     = json.getString("likes");
        workplace = json.getString("workplace");
        workhours = json.getString("workhours");
        longitude = json.getString("longitude");
        latitude  = json.getString("latitude");
    }

    public UserProfile()
    {

    }
}
