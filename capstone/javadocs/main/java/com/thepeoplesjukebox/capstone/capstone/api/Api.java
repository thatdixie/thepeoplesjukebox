package com.thepeoplesjukebox.jukebox.capstone.api;

import java.lang.*;
import java.io.*;
import java.net.*;
import java.util.*;
import com.thepeoplesjukebox.jukebox.tpj.model.*;
import com.thepeoplesjukebox.jukebox.json.*;
import com.thepeoplesjukebox.jukebox.common.*;
import com.thepeoplesjukebox.jukebox.rest.*;


/*********************************
 *       CAPSTONE  Rest API
 * -------------------------------
 *
 * functions:
 *
 * - catalog()
 * - currentlyPlaying()
 * - faq()
 * - login()
 * - permissions()
 * - playNext()
 * - searchProfiles()
 * - searchSongs()
 * - addQueue() 
 *
 * @author  Dixie
 *
 ********************************
 */
public class Api extends Object
{
    private String url          ="";
    private String auth         ="";
    private String username     ="";
    private String passcode     ="";
    private String password     ="";
    private String errorMessage ="";
    
    //-----------------------------
    // Get/Set functions
    //-----------------------------
    public void setUrl(String u)
    {
	url = u;
    }
    public String getUrl()
    {
	return(url);
    }
    public void setAuth(String a)
    {
	auth = a;
    }
    public String getAuth()
    {
	return(auth);
    }
    public String getUsername()
    {
	return(username);
    }
    public void setUsername(String u)
    {
	username = u;
    }
    public String getPassword()
    {
	return(password);
    }
    public void setPassword(String p)
    {
	password = p;
    }
    public String getPasscode()
    {
	return(passcode);
    }
    public void setPasscode(String p)
    {
	passcode = p;
    }
    public String getErrorMessage()
    {
	return(errorMessage);
    }
    public void setErrorMessage(String e)
    {
	errorMessage = e;
    }

   /**
    * catalog -- get a jukebox catalog 
    *
    * @param  int    -- jukeBoxId
    * @return ArrayList<Media> -- medias 
    */
    public ArrayList<Media> catalog(int jukeboxId)
    {
        ArrayList<Media>  medias = new ArrayList<Media>();

	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putInt("jukeboxId", jukeboxId);

	try
	{
	    //---------------------------------------------
	    // Here we call the REST function for catalog
	    //---------------------------------------------
	    resp  = rest.post("/api/catalog/", params);
	    JSONArray ja = new JSONArray(resp);
            int       l  = ja.length();
	    
            //--------------------------------------------
	    // This will be an array of Media Objects
	    // That is what catalog returns --
	    // So we construct a bunch of medias and
	    // pack them into an ArrayList that we return 
	    //--------------------------------------------
	    for(int i=0; i<l; i++)
	    {
                JSONObject jsonMedia  = ja.getJSONObject(i);
	        Media media = new Media(jsonMedia);
                medias.add(media);
	    }
	    
	    return(medias);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    medias = null;
	    return(medias);
	}
    }

   /**
    * faq -- get list of faqs 
    *
    */
    public ArrayList<Faq> faq()
    {
        ArrayList<Faq> faqs = new ArrayList<Faq>();

	//------------------------------------
	// instantiate a Rest() object...
	//------------------------------------
	String resp="";
	String url = getUrl();
	String auth= getAuth();
	Rest   rest= new Rest(url, auth);
	try
	{
	    //---------------------------------------------
	    // Here we call the REST function for faq
	    //---------------------------------------------
	    resp  = rest.get("/api/faq/", new DixieHash());
	    JSONArray ja = new JSONArray(resp);
            int       l  = ja.length();
	    
            //--------------------------------------------
	    // This will be an array of Faq Objects
	    // So we construct a bunch of faqs and
	    // pack them into an ArrayList that we return 
	    //--------------------------------------------
	    for(int i=0; i<l; i++)
	    {
                JSONObject jsonFaq  = ja.getJSONObject(i);
	        Faq faq = new Faq(jsonFaq);
                faqs.add(faq);
	    }
	    
	    return(faqs);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    faqs = null;
	    return(faqs);
	}
    }

    
   /**
    * searchProfiles -- find UserProfiles by search key
    *
    * @param  String searchKey
    * @return ArrayList<UserProfile> -- userprofile 
    */
    public ArrayList<UserProfile> searchProfiles(String searchKey)
    {
        ArrayList<UserProfile>  users = new ArrayList<UserProfile>();

	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putString("searchKey", searchKey);

	try
	{
	    //---------------------------------------------
	    // Here we call the REST function for catalog
	    //---------------------------------------------
	    resp  = rest.post("/api/search_profile/", params);
	    JSONArray ja = new JSONArray(resp);
            int       l  = ja.length();
	    
            //-----------------------------------------------
	    // This will be an array of UserProfile Objects
	    // So we construct a bunch of users and
	    // pack them into an ArrayList that we return 
	    //-----------------------------------------------
	    for(int i=0; i<l; i++)
	    {
                JSONObject jsonUserProfile  = ja.getJSONObject(i);
	        UserProfile userProfile = new UserProfile(jsonUserProfile);
                users.add(userProfile);
	    }
	    return(users);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    users = null;
	    return(users);
	}
    }


   /**
    * searchSongs -- find Media by search key
    *
    * @param  int                 jukeboxId
    * @param  String              searchKey
    * @return ArrayList<Media> -- medias 
    */
    public ArrayList<Media> searchSongs(int jukeboxId, String searchKey)
    {
        ArrayList<Media>  medias = new ArrayList<Media>();

	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putInt("jukeboxId", jukeboxId);
	params.putString("searchKey", searchKey);

	try
	{
	    //-------------------------------------------------
	    // Here we call the REST function for search_song
	    //-------------------------------------------------
	    resp  = rest.post("/api/search_song/", params);
	    JSONArray ja = new JSONArray(resp);
            int       l  = ja.length();
	    
            //-----------------------------------------------
	    // This will be an array of Media Objects
	    // So we construct a bunch of medias and
	    // pack them into an ArrayList that we return 
	    //-----------------------------------------------
	    for(int i=0; i<l; i++)
	    {
                JSONObject jsonMedia  = ja.getJSONObject(i);
	        Media media = new Media(jsonMedia);
                medias.add(media);
	    }
	    return(medias);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    medias = null;
	    return(medias);
	}
    }

    
   /**
    * currentlyPlaying 
    *
    * @param  int   -- jukeBoxId
    * @return Media -- media 
    */
    public Media currentlyPlaying(int id)
    {
	Media media = null;
	
	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putInt("jukeboxId", id);

	try
	{
	    //------------------------------------------------------
	    // Here we call the REST function for currently_playing
	    //------------------------------------------------------
	    resp  = rest.post("/api/currently_playing/", params);
            JSONObject jsonMedia  = new JSONObject(resp);
	    media = new Media(jsonMedia);

	    return(media);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    media = null;
	    return(media);
	}
    }

    /**
    * playNext 
    *
    * @param  int   -- jukeBoxId
    * @return Media -- media 
    */
    public Media playNext(int id)
    {
	Media media = null;
	
	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putInt("jukeboxId", id);

	try
	{
	    //------------------------------------------------------
	    // Here we call the REST function for currently_playing
	    //------------------------------------------------------
	    resp  = rest.post("/api/play_next/", params);
            JSONObject jsonMedia  = new JSONObject(resp);
	    media = new Media(jsonMedia);

	    return(media);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    media = null;
	    return(media);
	}
    }

    /**
    * addQueue -- request a song in a julkebox
    *
    * @param  int      -- jukeBoxId
    * @param  int      -- mediaId
    * @return Playlist -- playlist  
    */
    public Playlist addQueue(int jukeboxId, int mediaId)
    {
	Playlist playlist = null;
	
	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());
	params.putInt("jukeboxId", jukeboxId);
	params.putInt("mediaId"  , mediaId);

	try
	{
	    //------------------------------------------------------
	    // Here we call the REST function for currently_playing
	    //------------------------------------------------------
	    resp  = rest.post("/api/add_queue/", params);
            JSONObject jsonPlaylist  = new JSONObject(resp);
	    playlist = new Playlist(jsonPlaylist);

	    return(playlist);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    playlist = null;
	    return(playlist);
	}
    }


    
   /**
    * login 
    *
    */
    public User login()
    {
	User user = null;
	
	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("password", getPassword());

	try
	{
	    //---------------------------------------------
	    // Here we call the REST function for login
	    //---------------------------------------------
	    resp  = rest.post("/api/login/", params);
            JSONObject jsonUser  = new JSONObject(resp);
	    user = new User(jsonUser);
	    setPasscode(user.userPasscode);
	    return(user);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    user = null;
	    return(user);
	}
    }


   /**
    * permissions -- get user permissions 
    *
    */
    public ArrayList<Permission> permissions()
    {
        ArrayList<Permission>  permissions = new ArrayList<Permission>();

	//------------------------------------
	// set up username,passcode possibly
	// API authentecation yadda yadda
	// put into our parameter hash
	// and instantiate a Rest() object...
	//------------------------------------
	String url =getUrl();
	String auth=getAuth();
	String resp="";
	
	Rest rest        = new Rest(url, auth);
	DixieHash params = new DixieHash();
	params.putString("username", getUsername());
	params.putString("passcode", getPasscode());

	try
	{
	    //------------------------------------------------
	    // Here we call the REST function for permissions
	    //------------------------------------------------
	    resp  = rest.post("/api/permissions/", params);
	    JSONArray ja = new JSONArray(resp);
            int       l  = ja.length();
	    
            //------------------------------------------------
	    // This will be an array of Permission Objects
	    // So we construct one or more of permissionss
	    // and pack them into an ArrayList that we return 
	    //------------------------------------------------
	    for(int i=0; i<l; i++)
	    {
                JSONObject jsonPermission  = ja.getJSONObject(i);
	        Permission permission = new Permission(jsonPermission);
                permissions.add(permission);
	    }
	    
	    return(permissions);
	}
	catch(Exception e)
	{
	    determineError(resp);
	    permissions = null;
	    return(permissions);
	}
    }

   /**
    * detemineError  
    *
    * We got some kind of error...
    * try to determine source of error
    * then set errorMessage
    *
    * @param String resp -- the response from server 
    */
    private void determineError(String resp)
    {
        try
	{
            ApiError error = new ApiError( new JSONObject(resp));
            setErrorMessage(error.errorMessage);		
	}
	catch(Exception e)
	{
            setErrorMessage("Critical Server Error");
	}
    }

    
   /**
    * Here we have our happy constructors
    */
    public Api(String u, String a, String usr, String pass)
    {
	this.url      = u;
	this.auth     = a;
	this.username = usr;
	this.password = pass;
    }
    
    public Api()
    {
	
    }
}
