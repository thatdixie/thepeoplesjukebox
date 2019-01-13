package com.thepeoplesjukebox.capstone.tpj.model;

import java.lang.*;
import com.thepeoplesjukebox.capstone.json.*;

/**
 * Value Object for User using TPJ API 
 *
 * @author  Dixie
 */
public class User extends Object
{
    public int    userId        =0;
    public int    accountId     =0;
    public String userName      ="";
    public String userPassword  ="";
    public String userPasscode  ="";
    public String userFirstName ="";
    public String userLastName  ="";
    public String userIsJukebox ="";
    public String userNickName  ="";
    public String userLikes     ="";
    public String userWorkplace ="";
    public String userWorkHours ="";
    public String userPhoto     ="";
    public String userLongitude ="";
    public String userLatitude  ="";
    public String userLastLogin ="";
    public String userCreated   ="";
    public String userModified  ="";
    public String userStatus    ="";

    
    /**
     * Construct a User from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public User(JSONObject json)
    {
	userId        = json.getInt("userId");
	accountId     = json.getInt("accountId");
        userName      = json.getString("userName");
        userPassword  = json.getString("userPassword");
        userPasscode  = json.getString("userPasscode");
        userFirstName = json.getString("userFirstName");
        userLastName  = json.getString("userLastName");
        userIsJukebox = json.getString("userIsJukebox");
        userNickName  = json.getString("userNickName");
        userLikes     = json.getString("userLikes");
        userWorkplace = json.getString("userWorkplace");
        userWorkHours = json.getString("userWorkHours");
        userPhoto     = json.getString("userPhoto");
        userLongitude = json.getString("userLongitude");
        userLatitude  = json.getString("userLatitude");
        userLastLogin = json.getString("userLastLogin");
        userCreated   = json.getString("userCreated");
        userModified  = json.getString("userModified");
        userStatus    = json.getString("userStatus");
    }

    public User()
    {

    }
}
