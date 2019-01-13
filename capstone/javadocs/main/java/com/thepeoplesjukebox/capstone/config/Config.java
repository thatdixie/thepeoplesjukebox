package com.thepeoplesjukebox.capstone.config;

import com.thepeoplesjukebox.capstone.common.DixieHash;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.util.Iterator;
import java.util.Map;
import java.util.Properties;
import java.util.Set;

@SuppressWarnings("unchecked")

/**
 * Config object reads app settings from 
 * a file containing name=value pairs
 *
 * has save() method to save settings 
 * to local filesystem
 *
 * @author  Dixie
 */
public class Config extends DixieHash  
{
    private String confFile     = "jukebox.conf";
    private String errorMessage = "";
    
   /**
    * isTpjApi
    *
    * @return  boolean -- true or false
    */
    public boolean isTpjApi()
    {
        return(getBoolean("appcontext"));
    }

   /**
    * setIsTpjApp  
    *
    * @param  v -- true or false
    */
    public void setIsTpjApi(String v)
    {
        putString("appcontext", v);
    }
    
   /**
    * getApiUrl  
    *
    * @return  String -- APIURL
    */
    public String  getApiUrl()
    {
        return(getString("APIURL"));
    }

   /**
    * getApiAuth - Get Basic Auth encrypted string 
    *
    * @return  String -- AUTH
    */
    public String getApiAuth()
    {
        return(getString("AUTH"));
    }
    
   /**
    * setApiAuth  
    *
    * @param s -- Basic Auth encrypted string
    */
    public void setApiAuth(String s)
    {
        putString("AUTH", s);
    }

   /**
    * getUsername - get App owner username  
    *
    * @return  String -- username
    */
    public String getUsername()
    {
        return(getString("username"));
    }

   /**
    * setUsername  - sets App owner username
    *
    * @param s -- username
    */
    public void setUsername(String s)
    {
        putString("username", s);
    }

   /**
    * getPassword - get App owner password  
    *
    * @return  String -- password
    */
    public String getPassword()
    {
        return(getString("password"));
    }
    
   /**
    * setUsername  - sets App owner password
    *
    * @param s -- password
    */
    public void setPassword(String s)
    {
        putString("password", s);
    }
    
   /**
    * getPasscode - get App owner passcode  
    *
    * @return  String -- passcode
    */
    public String getPasscode()
    {
        return(getString("passcode"));
    }
    
   /**
    * setPasscode  - sets App owner passcode
    *
    * @param s -- passcode
    */
    public void setPasscode(String s)
    {
        putString("passcode", s);
    }

   /**
    * getErrorMessage - if there was any errors  
    *
    * @return  String -- errorMessage
    */
    public String getErrorMessage()
    {
        return(getString("errorMessage"));
    }

   /**
    * putROMConfig() -- Create default ROM App configuration.
    *
    */
    public void putROMConfig()
    {
    	putString("username", "");
	putString("password", "");
	putString("passcode", "");
	
	putString("appcontext","true");
	putString("APIURL", "http://thepeoplesjukebox.com");
	putString("AUTH","");
	
    }

   /**
    * save() -- Saves settings to local file system
    *
    */
    public void save()
    {
	try
	{
	    Properties       table= new Properties();

	    Set set = this.entrySet();
	    Iterator it = set.iterator();
	    while (it.hasNext())
	    {
	        Map.Entry entry = (Map.Entry) it.next();
	        table.setProperty((String)entry.getKey(), (String)entry.getValue());
	    }
        File             file = new File(this.confFile);
        FileOutputStream fos  = new FileOutputStream(file);
        table.store(fos,"Jukebox Settings");
        fos.close();
	}
	catch(Exception e)
        {
	    this.errorMessage = "save() failed: "+ this.confFile;	    
        }
    }
    
   /**
    * Public Constructor -- Reads params from properties file...
    *                       loads default ROM configuration for 
    *                       properties that may not be defined.
    *
    * @param conf -- jukebox.conf (or something)
    *
    */
    public Config( String conf )
    {
	putROMConfig();
        this.confFile    = conf;
        Properties props = new Properties();
        try
	{
	    File cf = new File(confFile);
            props.load(new FileInputStream(cf));
            putAll( props );
	}
        catch(Exception e)
	{
	    this.errorMessage = "Not found: "+ this.confFile;
	}
    }
}
