package com.thepeoplesjukebox.capstone.tpj.api;

import com.thepeoplesjukebox.capstone.common.DixieHash;
import com.thepeoplesjukebox.capstone.common.MessageNode;
import com.thepeoplesjukebox.capstone.common.Mos;
import com.thepeoplesjukebox.capstone.common.Semaphore;
import com.thepeoplesjukebox.capstone.json.JSONArray;
import com.thepeoplesjukebox.capstone.json.JSONObject;
import com.thepeoplesjukebox.capstone.rest.Rest;
import com.thepeoplesjukebox.capstone.tpj.model.*;

import java.util.ArrayList;


/*********************************
 *       TPJ Rest API Wrapper
 * -------------------------------
 *
 * public functions:
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
public class Api extends Mos
{
    private String url          ="";
    private String auth         ="";
    private String username     ="";
    private String passcode     ="";
    private String password     ="";
    private String errorMessage ="";
    private Semaphore uiSema    = null;
    private boolean doBackground= false;
    //------------------------------------------------
    // Shared Objects
    //------------------------------------------------
    private User                   user        = null;
    private Media                  media       = null;
    private Playlist               playlist    = null;
    private ArrayList<UserProfile> profiles    = null;
    private ArrayList<Permission>  permissions = null; 
    private ArrayList<Faq>         faqs        = null;
    private ArrayList<Media>       medias      = null;
    private byte[]                 photo       = null;
    private byte[]                 mp3         = null;
    private Upload                 upload      = null;

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
    
    private boolean isDoBackground()
    {
	return(doBackground);
    }
    
   /**
    * catalog -- get a jukebox catalog 
    *
    * @param  jukeboxId
    * @return ArrayList<Media> -- medias 
    */
    public  ArrayList<Media> catalog(int jukeboxId)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"  ,"catalog");
	        m.putInt("jukeboxId",jukeboxId);
	        sendMessage(m);
            uiSema.pwait();
            return(this.medias);
	    }
	    else
	        return(doCatalog(jukeboxId));
    }

	/**
	 * uploadCatalog -- upload a jukebox catalog
	 *
	 * @param  metaData
	 * @return Upload -- copy of Upload object
	 */
	public  Upload uploadCatalog(String metaData)
	{
		if(this.isDoBackground())
		{
			DixieHash m = new DixieHash();
			m.putString("func"    ,"uploadCatalog");
			m.putString("metadata",metaData);
			sendMessage(m);
			uiSema.pwait();
			return(this.upload);
		}
		else
			return(doUploadCatalog(metaData));
	}


	/**
    * faq -- get list of faqs 
    *
    */
    public ArrayList<Faq> faq()
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"  ,"faq");
	        sendMessage(m);
            uiSema.pwait();
            return(this.faqs);
	    }
	    else
	        return(doFaq());
    }

   /**
    * searchProfiles -- find UserProfiles by search key
    *
    * @param  searchKey
    * @return ArrayList<UserProfile> -- userprofile 
    */
    public ArrayList<UserProfile> searchProfiles(String searchKey)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"      ,"searchProfiles");
	        m.putString("searchKey" , searchKey);
	        sendMessage(m);
            uiSema.pwait();
            return(this.profiles);
        }
	    else
	        return(doSearchProfiles(searchKey));
    }


   /**
    * searchSongs -- find Media by search key
    *
    * @param  jukeboxId
    * @param  searchKey
    * @return ArrayList<Media> -- medias 
    */
    public ArrayList<Media> searchSongs(int jukeboxId, String searchKey)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"      ,"searchSongs");
	        m.putInt("jukeboxId"    , jukeboxId);
	        m.putString("searchKey" , searchKey);
	        sendMessage(m);
            uiSema.pwait();
            return(this.medias);
	    }
	    else
	        return(doSearchSongs(jukeboxId, searchKey));
    }

    /**
    * currentlyPlaying 
    *
    * @param  id
    * @return Media media
    */
    public Media currentlyPlaying(int id)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"   ,"currentlyPlaying");
	        m.putInt("jukeboxId" , id);
	        sendMessage(m);
            uiSema.pwait();
            return(this.media);
	    }
	    else
	        return(doCurrentlyPlaying(id));
    }

    /**
    * playNext 
    *
    * @param  id
    * @return Media media
    */
    public Media playNext(int id)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"   ,"playNext");
	        m.putInt("jukeboxId" , id);
	        sendMessage(m);
            uiSema.pwait();
            return(this.media);
	    }
	    else
	        return(doPlayNext(id));
    }

    /**
    * addQueue -- request a song in a julkebox
    *
    * @param  jukeboxId
    * @param  mediaId
    * @return Playlist -- playlist  
    */
    public Playlist addQueue(int jukeboxId, int mediaId)
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func"  ,"addQueue");
	        m.putInt("jukeboxId", jukeboxId);
	        m.putInt("mediaId"  , mediaId);
	        sendMessage(m);
            uiSema.pwait();
            return(this.playlist);
	    }
	    else
	        return(doAddQueue(jukeboxId, mediaId));
    }

   /**
    * login 
    *
    */
    public User login()
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func","login");
	        sendMessage(m);
            uiSema.pwait();
	        return(this.user);
	    }
	    else
	        return(doLogin());
    }

   /**
    * permissions -- get user permissions 
    *
    */
    public ArrayList<Permission> permissions()
    {
        if(this.isDoBackground())
	    {
	        DixieHash m = new DixieHash();
	        m.putString("func","permissions");
	        sendMessage(m);
            uiSema.pwait();
	        return(this.permissions);
	    }
	    else
	        return(doPermissions());
    }

    /**
     * getUserPhoto
     *
     * @param  id
     * @return photo
     */
    public byte[] getUserPhoto(int id)
    {
        if(this.isDoBackground())
        {
            DixieHash m = new DixieHash();
            m.putString("func"   ,"getUserPhoto");
            m.putInt("userId" , id);
            sendMessage(m);
            uiSema.pwait();
            return(this.photo);
        }
        else
            return(doGetUserPhoto(id));
    }

    /**
     * getUserMp3
     *
     * @param  id
     * @return mp3
     */
    public byte[] getUserMp3(int id)
    {
        if(this.isDoBackground())
        {
            DixieHash m = new DixieHash();
            m.putString("func"   ,"getUserMp3");
            m.putInt("userId" , id);
            sendMessage(m);
            uiSema.pwait();
            return(this.mp3);
        }
        else
            return(doGetUserMp3(id));
    }

    
   /*
    *************************************************************************
    * This is the messageHandler() when API isDoBackground() is true.
    * it is called from Mos.run() when a message to do API command is 
    * posted via sendMessage() -- messageHandler()  unpacks the message
    * and determines the function requested  and its arguments and calls it.  
    * the results placeed in the shared objects so that the waiting UI
    * thread and access it when its background thread is complete.
    *************************************************************************
    */
    public void messageHandler(MessageNode n)
    {
        DixieHash m = (DixieHash)n.object;
	    String func = m.getString("func");

	if(func.equals("catalog"))
	{
	    int jukeboxId = m.getInt("jukeboxId");
	    this.medias   = doCatalog(jukeboxId);
	    uiSema.signal();
	}
	else if(func.equals("currentlyPlaying"))
	{
	    int jukeboxId = m.getInt("jukeboxId");
	    this.media    = doCurrentlyPlaying(jukeboxId);
	    uiSema.signal();
	}
	else if(func.equals("faq"))
	{
	    this.faqs = doFaq();
	    uiSema.signal();
	}
	else if(func.equals("login"))
	{
	    this.user = doLogin();
	    uiSema.signal();
	}
	else if(func.equals("permissions"))
	{
	    this.permissions = doPermissions();
	    uiSema.signal();
	}
	else if(func.equals("playNext"))
	{
	    int jukeboxId = m.getInt("jukeboxId");
	    this.media    = doPlayNext(jukeboxId);
	    uiSema.signal();
	}
	else if(func.equals("searchProfiles"))
	{
	    String searchKey = m.getString("searchKey");
	    this.profiles    = doSearchProfiles(searchKey);
	    uiSema.signal();
	}
	else if(func.equals("searchSongs"))
	{
	    int jukeboxId    = m.getInt("jukeboxId");
	    String searchKey = m.getString("searchKey");
	    this.medias      = doSearchSongs(jukeboxId, searchKey);
	    uiSema.signal();
	}
	else if(func.equals("addQueue"))
	{
	    int jukeboxId = m.getInt("jukeboxId");
	    int mediaId   = m.getInt("mediaId");
	    this.playlist = doAddQueue(jukeboxId, mediaId);
	    uiSema.signal();
	}
    else if(func.equals("getUserPhoto"))
    {
        int photoId = m.getInt("userId");
        this.photo = doGetUserPhoto(photoId);
        uiSema.signal();
    }
    else if(func.equals("getUserMp3"))
    {
        int mp3Id = m.getInt("userId");
        this.mp3 = doGetUserMp3(mp3Id);
        uiSema.signal();
    }
	else if(func.equals("uploadCatalog"))
	{
		String metaData = m.getString("metadata");
		this.upload = doUploadCatalog(metaData);
		uiSema.signal();
	}
    else
	    return;
    }

   /*
    *************************************************************************
    * The following are the *actual* API calls. They can be called directly
    * from the API wrapper public methods or via the messageHandler() 
    * when API isDoBackground() is true.
    *************************************************************************
    */
    
    
   /**
    * doCatalog -- get a jukebox catalog 
    *
    * @param  jukeboxId
    * @return ArrayList<Media> -- medias 
    */
    private ArrayList<Media> doCatalog(int jukeboxId)
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
	    setErrorMessage("");
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
	 * doCatalog -- upload a jukebox catalog
	 *
	 * @param  metaData
	 * @return Upload -- copy of Upload object
	 */
	private Upload doUploadCatalog(String metaData)
	{
		upload = new Upload();

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
		params.putString("metadata", metaData);

		try
		{
			//---------------------------------------------------
			// Here we call the REST function for upload_catalog
			//---------------------------------------------------
			resp  = rest.post("/api/upload_catalog/", params);
			JSONObject jsonUpload = new JSONObject(resp);
			upload = new Upload(jsonUpload);
			setErrorMessage("");
			return(upload);
		}
		catch(Exception e)
		{
			determineError(resp);
			upload = null;
			return(upload);
		}
	}


	/**
    * doFaq -- get list of faqs 
    *
    */
    private ArrayList<Faq> doFaq()
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
		setErrorMessage("");
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
    * doSearchProfiles -- find UserProfiles by search key
    *
    * @param  searchKey
    * @return ArrayList<UserProfile> -- userprofile 
    */
    private ArrayList<UserProfile> doSearchProfiles(String searchKey)
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
	    //--------------------------------------------------
	    // Here we call the REST function for search_profile
	    //--------------------------------------------------
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
		setErrorMessage("");
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
    * doSearchSongs -- find Media by search key
    *
    * @param  jukeboxId
    * @param  searchKey
    * @return ArrayList<Media> -- medias 
    */
    private ArrayList<Media> doSearchSongs(int jukeboxId, String searchKey)
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
		setErrorMessage("");
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
    * doCurrentlyPlaying 
    *
    * @param  id
    * @return Media media
    */
    private Media doCurrentlyPlaying(int id)
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
		setErrorMessage("");
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
    * doPlayNext 
    *
    * @param  id
    * @return Media media
    */
    private Media doPlayNext(int id)
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
			setErrorMessage("");
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
    * doAddQueue -- request a song in a julkebox
    *
    * @param  jukeboxId
    * @param  mediaId
    * @return playlist
    */
    private Playlist doAddQueue(int jukeboxId, int mediaId)
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
	    // Here we call the REST function for add_queue
	    //------------------------------------------------------
	    resp  = rest.post("/api/add_queue/", params);
	    JSONObject jsonPlaylist  = new JSONObject(resp);
	    playlist = new Playlist(jsonPlaylist);
		setErrorMessage("");
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
    * doLogin 
    *
    */
    private User doLogin()
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
		setErrorMessage("");
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
    * doPermissions -- get user permissions 
    *
    */
    private ArrayList<Permission> doPermissions()
    {
        ArrayList<Permission> permissions = new ArrayList<Permission>();

        //------------------------------------
        // set up username,passcode possibly
        // API authentecation yadda yadda
        // put into our parameter hash
        // and instantiate a Rest() object...
        //------------------------------------
        String url = getUrl();
        String auth = getAuth();
        String resp = "";

        Rest rest = new Rest(url, auth);
        DixieHash params = new DixieHash();
        params.putString("username", getUsername());
        params.putString("passcode", getPasscode());

        try
        {
            //------------------------------------------------
            // Here we call the REST function for permissions
            //------------------------------------------------
            resp = rest.post("/api/permissions/", params);
            JSONArray ja = new JSONArray(resp);
            int l = ja.length();

            //------------------------------------------------
            // This will be an array of Permission Objects
            // So we construct one or more of permissionss
            // and pack them into an ArrayList that we return
            //------------------------------------------------
            for (int i = 0; i < l; i++)
            {
                JSONObject jsonPermission = ja.getJSONObject(i);
                Permission permission = new Permission(jsonPermission);
                permissions.add(permission);
            }
			setErrorMessage("");
            return (permissions);
        } catch (Exception e)
        {
            determineError(resp);
            permissions = null;
            return (permissions);
        }
    }
    /**
     * doGetUserPhoto -- get user photo via photoViewer
     *
     */
    private byte[] doGetUserPhoto(int userId)
    {
        String url=getUrl();
        String auth=getAuth();
        String resp="";

        Rest rest        = new Rest(url, auth);
        DixieHash params = new DixieHash();
        params.putInt("userId", userId);

        try
        {
            //------------------------------------------------
            // Here we call the function that renders a photo
            //------------------------------------------------
            photo = rest.getDataBytes("/user/photoviewer.php", params);
            return(photo);
        }
        catch(Exception e)
        {
            photo= null;
            return(photo);
        }
    }


    /**
     * doGetUserMp3 -- get user mp3 via mp3player
     *
     */
    private byte[] doGetUserMp3(int jukeboxId)
    {
        String url=getUrl();
        String auth=getAuth();
        String resp="";

        Rest rest        = new Rest(url, auth);
        DixieHash params = new DixieHash();
        params.putInt("jukeboxId", jukeboxId);

        try
        {
            //------------------------------------------------
            // Here we call the function that renders a mp3
            //------------------------------------------------
			mp3 = rest.getDataBytes("/mp3player/mp3player.php", params);
            return(mp3);
        }
        catch(Exception e)
        {
            mp3= null;
            return(mp3);
        }
    }

   /**
    * detemineError  
    *
    * We got some kind of error...
    * try to determine source of error
    * then set errorMessage
    *
    * @param resp -- the response from server
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
	        setErrorMessage("API Server Error");
	    }
    }

    
   /**
    *  if this is called we are doing 
    *  the API functions in a background thread
    * 
    *  start() starts that thread...
    */
    public void start()
    {
	    this.doBackground = true;
	    this.uiSema       = new Semaphore(0);
        super.start();
    }
    
   /**
    * Here we have our happy constructors
    */
    public Api(String u, String a, String usr, String pass)
    {
	    super("API Background Thread");

	    this.url      = u;
	    this.auth     = a;
	    this.username = usr;
	    this.password = pass;
        this.doBackground = false;
    }
    
    public Api()
    {
	    super("API Background Thread");
        this.doBackground = false;
    }
}
