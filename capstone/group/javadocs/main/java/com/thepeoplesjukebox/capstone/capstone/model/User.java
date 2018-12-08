package com.thepeoplesjukebox.jukebox.capstone.model;

import java.lang.*;
import com.thepeoplesjukebox.jukebox.json.*;

/**
 * Value Object for User using Capstone API 
 *
 * @author  Dixie
 */
public class User extends Object
{

    public int     id               =0;
    public int     sessionId        =0;
    public boolean active           =false;
    public String  email            ="";
    public String  firstName        ="";
    public String  lastName         ="";
    public String  password         ="";
    public boolean isRegistered     =false;
    public boolean isActivated      =false;
    public String  verificationCode ="";
    public String  createdAt        ="";
    public String  updatedAt        ="";
    
    /**
     * Construct a User from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public User(JSONObject json)
    {
        id               = json.getInt("id");
        sessionId        = json.getInt("sessionId");
        active           = json.getBoolean("active");
        email            = json.getString("email");
        firstName        = json.getString("firstName");
        lastName         = json.getString("lastName");
        password         = json.getString("password");
        isRegistered     = json.getBoolean("isRegistered");
        isActivated      = json.getBoolean("isActivated");
        verificationCode = json.getString("verificationCode");
	createdAt        = json.getString("createdAt");
	updatedAt        = json.getString("updatedAt");       
    }

    public User()
    {

    }
}
