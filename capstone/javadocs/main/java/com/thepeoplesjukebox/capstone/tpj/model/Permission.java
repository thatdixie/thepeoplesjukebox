package com.thepeoplesjukebox.capstone.tpj.model;

import java.lang.*;
import com.thepeoplesjukebox.capstone.json.*;

/**
 * Value Object for Permission using TPJ API 
 *
 * @author  Dixie
 */
public class Permission extends Object
{

    public int    permissionId   =0;
    public String permissionName ="";
    
    /**
     * Construct a Permission from a JSONObject.
     *
     * @param json
     *            A JSONObject.
     */
    public Permission(JSONObject json)
    {
        permissionId   = json.getInt("permissionId");
        permissionName = json.getString("permissionName");
    }

    public Permission()
    {

    }
}
