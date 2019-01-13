package com.thepeoplesjukebox.capstone;

import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.MediaMetadataRetriever;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.util.Linkify;
import android.util.Log;
import android.view.*;
import android.widget.*;
import com.thepeoplesjukebox.capstone.config.Config;
import com.thepeoplesjukebox.capstone.json.JSONArray;
import com.thepeoplesjukebox.capstone.json.JSONObject;
import com.thepeoplesjukebox.capstone.tpj.api.Api;
import com.thepeoplesjukebox.capstone.tpj.model.Media;
import com.thepeoplesjukebox.capstone.tpj.model.User;

import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.regex.Pattern;


public class Capstone extends AppCompatActivity {

    private MediaPlayer player;
    private Api api;
    private byte[] mp3;
    private byte[] photo = null;
    private Config config;
    private User  user;
    private Media media;
    private ArrayList<Media> medias =null;
    private String[] mediaArray =null;
    private String userPassword ="";
    private String userPasscode ="";
    private String userUsername ="";
    private String mediaPlaying;
    private Capstone context =null;
    private Toolbar toolbar;
    private ImageView splash;
    private boolean jukeboxStarted = false;
    private DBHelper jukeboxDB ;
    //------------------------------------
    // MediaPlayer stuff...
    //------------------------------------
    private Button playButton,pauseButton,stopButton,nextButton,
                   updateButton, settingsCancelButton;
    private ImageView iv;
    private MediaPlayer mediaPlayer;

    private double startTime = 0;
    private double finalTime = 0;

    private Handler myHandler = new Handler();;
    private int forwardTime = 5000;
    private int backwardTime = 5000;
    private SeekBar seekbar;
    public static int oneTimeOnly = 0;
    //------------------------------------------
    // Login and App settings stuff...
    //-------------------------------------------
    private Button   loginButton, cancelButton, backButton,
                     syncButton, syncBackButton, syncPageButton;
    private EditText editLogin, editPassword,
                     editAppContext, editApiUrl, editAuth;
    private int counter = 3;


    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        //-----------------------------------------------
        // setup main activity and menu items...
        //------------------------------------------------
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_jukebox_home);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        //-----------------------------------------------
        // make sure keyboard dosn't open un-expectantly
        //-----------------------------------------------
        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
        context = this;
    }

    @Override
    public void onStart()
    {
        super.onStart();
        if(!jukeboxStarted)
        {
            initConfig();
            initApi();

            user = doLogin();
            if (user != null)
            {
                userPassword = config.getPassword();
                userUsername = config.getUsername();
                userPasscode = user.userPasscode;
                loginGood();
            }
            else
            {
                viewLoginForm();
            }
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_capstone, menu);
        return true;
    }

    /**
     * onOptionsItemSelected() -- This method handles selection
     *                             of items in menubar it is
     *                             called with MenuItem() reference
     * @param  item
     * @return item
     */
    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        //---------------------------------------------------------------
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as we specify a parent activity in AndroidManifest.xml.
        //---------------------------------------------------------------
        int id = item.getItemId();

        if (id == R.id.action_catalog)
        {
            if(jukeboxStarted)
            {
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
                return true;
            }
            viewJukeboxCatalog();
            return true;
        }

        if (id == R.id.action_sync_catalog)
        {
            if(jukeboxStarted)
            {
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
                return true;
            }
            viewSyncOption();
            return true;
        }

        if (id == R.id.action_play_jukebox)
        {
            if(jukeboxStarted)
            {
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
                return true;
            }
            startJukeboxHome();
            return true;
        }

        if (id == R.id.action_logout)
        {
            if(jukeboxStarted)
            {
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
                return true;
            }
            viewLoginForm();
            return true;
        }

        if (id == R.id.action_about)
        {
            if(jukeboxStarted)
            {
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
                return true;
            }
            viewAbout();
            return true;
        }

        if (id == R.id.action_settings)
        {
            if(jukeboxStarted)
                Toast.makeText(getApplicationContext(), "Stop your jukebox first!", Toast.LENGTH_SHORT).show();
            else
                viewSettingsForm();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }


    /**
     * restartJukeboxActivity() -- resets and restarts tthe jukebox_home activity
     *
     */
    public void restartJukeboxActivity()
    {
        //--------------------------
        // stop music if playing...
        //--------------------------
        if(mediaPlayer != null)
            mediaPlayer.stop();
        mediaPlayer =null;
        //--------------------------
        // stop api thread...
        //---------------------------
        api.stopRunning();
        //--------------------------------------
        // restart application
        //--------------------------------------
        Intent i = getBaseContext().getPackageManager()
                .getLaunchIntentForPackage( getBaseContext().getPackageName() );
        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(i);
    }

    /**
     * viewAbout() -- the About Screen
     *
     */
    public void viewAbout()
    {
        setContentView(R.layout.activity_jukebox_about);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        backButton  = (Button)findViewById(R.id.about_back_button);
        TextView t1  = (TextView)findViewById(R.id.about_header);
        TextView t2  = (TextView)findViewById(R.id.about_version);
        t1.setText(R.string.action_about);
        t2.setText(R.string.action_about_version);

        backButton.setOnClickListener(new View.OnClickListener()
        {

            @Override
            public void onClick(View v)
            {
                startJukeboxHome();
            }
        });
    }


    /**
     * viewLoginForm() -- if login good we show our jukebox
     *
     */
    public void viewLoginForm()
    {
        setContentView(R.layout.activity_jukebox_login);

        loginButton  = (Button)findViewById(R.id.login_button);
        editLogin    = (EditText)findViewById(R.id.edit_login);
        editPassword = (EditText)findViewById(R.id.edit_password);
        cancelButton = (Button)findViewById(R.id.cancel_button);
        TextView t1  = (TextView)findViewById(R.id.login_text);
        TextView t2  = (TextView)findViewById(R.id.forgot_password);
        t1.setText(R.string.login);
        Pattern pattern = Pattern.compile("[a-zA-Z]");
        t2.setText(R.string.forgot_password);
        Linkify.addLinks(t2,pattern,"http://thepeoplesjukebox.com/signup/?q=");

        loginButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                if (editLogin.getText().toString().equals("") || editPassword.getText().toString().equals(""))
                {
                    Toast.makeText(getApplicationContext(), "Enter valid email and password", Toast.LENGTH_SHORT).show();
                }
                else
                {
                    loginButton.setEnabled(false);
                    cancelButton.setEnabled(false);
                    api.setUsername(editLogin.getText().toString());
                    api.setPassword(editPassword.getText().toString());
                    userPassword=editPassword.getText().toString();
                    userUsername=editLogin.getText().toString();
                    userUsername=editLogin.getText().toString();
                    user = doLogin();
                    if(user == null)
                    {
                        Toast.makeText(getApplicationContext(), "Login Failed", Toast.LENGTH_SHORT).show();
                        loginButton.setEnabled(true);
                        cancelButton.setEnabled(true);
                        Log.e("Jukebox", api.getErrorMessage());
                        return;
                    }
                    Toast.makeText(getApplicationContext(), "Logging in...", Toast.LENGTH_SHORT).show();
                    loginGood();
                }
            }
        });

        cancelButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                //finish();
            }
        });
    }

    /**
     * loginGood() -- if login good we show our jukebox
     *
     */
    public void loginGood()
    {
        //-------------------------------------------
        // First save configuration...
        //--------------------------------------------
        userUsername = user.userName;
        userPasscode = user.userPasscode;
        saveConfig();
        startJukeboxHome();
    }

    /**
     * startJukeboxHome() -- start our jukebox!
     *
     */
    public void startJukeboxHome()
    {
        //-----------------------------------------------
        // Set layout view to jukebox home...
        //-----------------------------------------------
        setContentView(R.layout.activity_jukebox_home);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_NOSENSOR);
        //-------------------------------------------------
        // setup media for next song...
        //-------------------------------------------------
        jukeboxStarted = false;
        photo =null;

        media = api.playNext(user.userId);
        while (media == null)
        {   //-----------------------------------
            // THIS IS JUST FUCKING WEIRD!
            // TODO: LOOK INTO THIS
            //------------------------------------
            media = api.playNext(user.userId);
        }

        mediaPlaying = media.mediaTitle + "--" + media.mediaArtist;
        //-------------------------------------
        // view jukebox...
        //--------------------------------------
        viewJukebox();
    }

    /**
     * viewJukebox() -- shows a jukebox profile with mediaPlayer
     *
     */
    public void viewJukebox ()
    {
        TextView t1 = (TextView) findViewById(R.id.jukebox_title);
        t1.setGravity(Gravity.CENTER);
        t1.setText(user.userNickName + "'s Jukebox playing...");
        TextView t2 = (TextView) findViewById(R.id.now_playing);
        t2.setGravity(Gravity.CENTER);
        t2.setText(mediaPlaying);
        getJukeboxPhoto();
        getJukeboxMusic();
        viewMediaPlayer();
    }


    /**
     * getJukeboxPhoto() -- uses API wrapper to get PHOTO file from server
     *                          sets in approperiate ImageView
     */
    public void getJukeboxPhoto()
    {
        ImageView iv = (ImageView)findViewById(R.id.jukebox_photo);
        if(photo == null)
        {
            photo = api.getUserPhoto(user.userId);
        }
        Bitmap b     = BitmapFactory.decodeByteArray(photo, 0, photo.length);
        b            = Bitmap.createScaledBitmap(b, b.getWidth()*5, b.getHeight()*5, false);
        iv.setImageBitmap(b);
    }

    /**
     * getukeboxMusic() -- uses API wrapper to get MP3 file from server or local storage
     *
     */
    public void getJukeboxMusic()
    {
        try
        {
            if(media.mediaSource.equals("UPLOAD"))
            {
                String mediaFile = Environment.getExternalStorageDirectory().getPath() + "/tmp.mp3";
                mp3 = api.getUserMp3(user.userId);
                BufferedOutputStream bos = new BufferedOutputStream(new FileOutputStream(mediaFile));
                bos.write(mp3);
                bos.flush();
                bos.close();
            }
        }
        catch (Exception e)
        {
            Log.e("Jukebox", e.getStackTrace().toString());
        }
    }


    /**
     * viewMediaPlayer() -- render mediaplayer with buttons for
     *                      play pause stop and next
     *
     */
    public void viewMediaPlayer()
    {
        String mediaFile;
        playButton = (Button) findViewById(R.id.play_button);
        pauseButton = (Button) findViewById(R.id.pause_button);
        stopButton = (Button) findViewById(R.id.stop_button);
        nextButton = (Button) findViewById(R.id.next_button);
        if(media.mediaSource.equals("UPLOAD"))
            mediaFile = mediaFile = Environment.getExternalStorageDirectory().getPath() + "/tmp.mp3";
        else
            mediaFile = android.os.Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_MUSIC)+"/"+
                        media.mediaFile;
        mediaPlayer = MediaPlayer.create(this, Uri.parse(mediaFile));
        seekbar = (SeekBar) findViewById(R.id.seekBar);
        seekbar.setClickable(true);
        playButton.setEnabled(true);
        pauseButton.setEnabled(false);
        stopButton.setEnabled(false);
        nextButton.setEnabled(false);

        mediaPlayer.setOnCompletionListener(new MediaPlayer.OnCompletionListener()
        {
            @Override
            public void onCompletion(MediaPlayer mediaPlayer)
            {
                mediaDoOver();
            }
        });

        playButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Toast.makeText(getApplicationContext(), "Jukebox Playing!", Toast.LENGTH_SHORT).show();
                mediaPlayer.start();

                finalTime = mediaPlayer.getDuration();
                startTime = mediaPlayer.getCurrentPosition();

                if (oneTimeOnly == 0)
                {
                    seekbar.setMax((int) finalTime);
                    oneTimeOnly = 0;
                }

                seekbar.setProgress((int) startTime);
                myHandler.postDelayed(UpdateSongTime, 100);
                pauseButton.setEnabled(true);
                stopButton.setEnabled(true);
                nextButton.setEnabled(true);
                playButton.setEnabled(false);
                jukeboxStarted = true;
                viewJukeboxPhoto();
            }
        });

        pauseButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Toast.makeText(getApplicationContext(), "Jukebox Paused!", Toast.LENGTH_SHORT).show();
                mediaPlayer.pause();
                pauseButton.setEnabled(false);
                stopButton.setEnabled(false);
                nextButton.setEnabled(true);
                playButton.setEnabled(true);
                jukeboxStarted = false;
            }
        });

        stopButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Toast.makeText(getApplicationContext(), "Jukebox Stopped!",Toast.LENGTH_SHORT).show();
                mediaPlayer.pause();
                pauseButton.setEnabled(false);
                stopButton.setEnabled(false);
                playButton.setEnabled(true);
                nextButton.setEnabled(true);
                jukeboxStarted = false;
            }
        });

        nextButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Toast.makeText(getApplicationContext(), "Playing Next Jukebox Song!",Toast.LENGTH_SHORT).show();
                mediaPlayer.stop();
                mediaDoOver();
            }
        });
    }

    /**
     * mediaDoOver() -- re-create mediaplayer
     *                  invoke api.playNext()
     *                  set callback that calls THIS method forever
     *
     */
    public void mediaDoOver()
    {
        media = api.playNext(user.userId);
        while (media == null)
        {   //-----------------------------------
            // THIS IS JUST FUCKING WEIRD!
            // TODO: LOOK INTO THIS
            //------------------------------------
            media = api.playNext(user.userId);
        }

        mediaPlaying = media.mediaTitle + "--" + media.mediaArtist;

        finalTime = mediaPlayer.getDuration();
        startTime = mediaPlayer.getCurrentPosition();

        if (oneTimeOnly == 0)
        {
            seekbar.setMax((int) finalTime);
            oneTimeOnly = 0;
        }
        seekbar.setProgress((int) startTime);
        myHandler.postDelayed(UpdateSongTime, 100);
        pauseButton.setEnabled(true);
        stopButton.setEnabled(true);
        nextButton.setEnabled(true);
        playButton.setEnabled(false);

        TextView t2 = (TextView) findViewById(R.id.now_playing);
        t2.setGravity(Gravity.CENTER);
        t2.setText(context.mediaPlaying);
        getJukeboxMusic();
        String mediaFile;
        if(media.mediaSource.equals("UPLOAD"))
            mediaFile = mediaFile = Environment.getExternalStorageDirectory().getPath() + "/tmp.mp3";
        else
            mediaFile = android.os.Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_MUSIC)+"/"+
                    media.mediaFile;
        Log.e("Jukebox",mediaFile);
        mediaPlayer = MediaPlayer.create(context, Uri.parse(mediaFile));
        seekbar = (SeekBar) findViewById(R.id.seekBar);
        seekbar.setClickable(true);
        finalTime = mediaPlayer.getDuration();
        startTime = mediaPlayer.getCurrentPosition();
        seekbar.setProgress((int) startTime);

        mediaPlayer.setOnCompletionListener(new MediaPlayer.OnCompletionListener()
        {
            @Override
            public void onCompletion(MediaPlayer mediaPlayer)
            {
                mediaDoOver();
            }
        });

        viewJukeboxPhoto();
        mediaPlayer.start();
    }


    /**
     * viewJukeboxPhoto() -- displays jukebox photo or album art if it finds album art
     *
     */
    public void viewJukeboxPhoto()
    {
        if(media.mediaSource.equals("LOCAL"))
        {
            MediaMetadataRetriever mmr = new MediaMetadataRetriever();
            File musicDir = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_MUSIC);
            mmr.setDataSource(musicDir.toString()+"/"+media.mediaFile);
            byte [] data = mmr.getEmbeddedPicture();
            if(data != null)
            {
                ImageView iv = (ImageView) findViewById(R.id.jukebox_photo);
                Bitmap b = BitmapFactory.decodeByteArray(data, 0, data.length);
                b = Bitmap.createScaledBitmap(b, b.getWidth() , b.getHeight() , false);
                iv.setImageBitmap(b);
            }
            else
            {
                ImageView iv = (ImageView) findViewById(R.id.jukebox_photo);
                Bitmap b     = BitmapFactory.decodeByteArray(photo, 0, photo.length);
                b            = Bitmap.createScaledBitmap(b, b.getWidth()*5, b.getHeight()*5, false);
                iv.setImageBitmap(b);
            }
        }
        else
        {
            ImageView iv = (ImageView) findViewById(R.id.jukebox_photo);
            Bitmap b     = BitmapFactory.decodeByteArray(photo, 0, photo.length);
            b            = Bitmap.createScaledBitmap(b, b.getWidth()*5, b.getHeight()*5, false);
            iv.setImageBitmap(b);
        }
    }

    /**
     * UpdateSongTime() -- Thread class that updates seekbar...
     *
     */
    private Runnable UpdateSongTime = new Runnable()
    {
        public void run()
        {
            if (mediaPlayer != null)
            {
                startTime = mediaPlayer.getCurrentPosition();
                seekbar.setProgress((int) startTime);
                myHandler.postDelayed(this, 100);
            }
        }
    };


    /**
     * getJukeboxCatalog() -- gets catalog list for a jukebox via REST API
     *
     */
    public void getJukeboxCatalog()
    {
        boolean inProgress=true;

        while(inProgress)
        {
            medias = api.catalog(user.userId);
            if(medias != null)
            {
                if (medias.get(0).mediaId == 0)
                {
                    //----------------------------------------------
                    // display "Processing sync till catalog ready
                    //----------------------------------------------
                    String[] proc ={"Processing SYNC..."};
                    ArrayAdapter adapter = new ArrayAdapter<String>(this, R.layout.layout_jukebox_catalog, proc);
                    ListView listView = (ListView) findViewById(R.id.catalog_list);
                    listView.setAdapter(adapter);
                }
                else
                    inProgress = false;
            }
        }
        int l      = medias.size();
        mediaArray = new String[l];

        for(int i=0; i<l; i++)
        {
            Media m =  medias.get(i);
            mediaArray[i] = m.mediaTitle+"--"+m.mediaArtist;
        }
    }

    /**
     * syncCatalog() -- Collects meta-data from music files in /Music folder and uploads
     *                  to the peoples jukebox catalog via API
     *
     */
    public void syncCatalog()
    {
        //-----------------------------------------------------------------------------
        // First we're gonna peek into the /Music directory and see what's there...
        //-----------------------------------------------------------------------------
        File musicDir = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_MUSIC);
        File[] files  = musicDir.listFiles();
        MediaMetadataRetriever mmr = new MediaMetadataRetriever();
        JSONArray ja = new JSONArray();

        for(int i=0; i<files.length; i++)
        {
            String filename = files[i].getName();
            mmr.setDataSource(musicDir.toString()+"/"+filename);
            //-------------------------------------------------------
            // Create a Media object from meta data...
            //-------------------------------------------------------
            Media m = new Media();
            m.mediaId =0;
            m.userId=user.userId;
            m.mediaFile=filename;
            m.mediaSource="LOCAL";
            m.mediaArtist=mmr.extractMetadata(MediaMetadataRetriever.METADATA_KEY_ARTIST);
            m.mediaTitle =mmr.extractMetadata(MediaMetadataRetriever.METADATA_KEY_TITLE);
            m.mediaYear  ="1900";
            m.mediaDuration="180";
            m.mediaCreated = "2018-10-08 22:28:29";
            m.mediaModified= "2018-10-08 22:28:29";
            m.mediaStatus="ACTIVE";
            //----------------------------------------
            // Add Media object to a JSONArray...
            //----------------------------------------
            if(m.mediaFile.indexOf('&') == -1 && m.mediaArtist!=null && m.mediaTitle!=null)
            {
                JSONObject jo = new JSONObject();
                jo.put("mediaId", m.mediaId);
                jo.put("userId", m.userId);
                jo.put("mediaFile", m.mediaFile);
                jo.put("mediaSource", m.mediaSource);
                jo.put("mediaArtist", m.mediaArtist.replaceAll("&", "and"));
                jo.put("mediaTitle", m.mediaTitle.replaceAll("&", "and"));
                jo.put("mediaYear", m.mediaYear);
                jo.put("mediaDuration", m.mediaYear);
                jo.put("mediaCreated", m.mediaCreated);
                jo.put("mediaModified", m.mediaModified);
                jo.put("mediaStatus", m.mediaStatus);
                ja.put(jo);
            }
        }
        //------------------------------------------
        // Upload meta-data via REST API
        //-------------------------------------------
        api.uploadCatalog(ja.toString(4));
    }


    /**
     * viewJukeboxCatalog() -- screen displays jukebox catalog listing with controls
     *                         to add delete and modify entries.
     *
     */
    public void viewJukeboxCatalog()
    {
        setContentView(R.layout.activity_jukebox_catalog);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        //-----------------------------------------
        // get all the currently installed songs
        //------------------------------------------
        getJukeboxCatalog();

        //------------------------------------------
        // Display catalog...
        //-------------------------------------------
        ArrayAdapter adapter = new ArrayAdapter<String>(this, R.layout.layout_jukebox_catalog, mediaArray);

        ListView listView = (ListView) findViewById(R.id.catalog_list);
        listView.setAdapter(adapter);

    }


    /**
     * viewSyncOption() -- screen displays jukebox sync option
     *                     to upload meta data from music folder.
     *
     */
    public void viewSyncOption()
    {
        setContentView(R.layout.activity_jukebox_sync);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        syncButton     = (Button)findViewById(R.id.sync_now_button);
        syncBackButton = (Button)findViewById(R.id.sync_back_button);

        TextView t1  = (TextView)findViewById(R.id.sync_header);
        TextView t2  = (TextView)findViewById(R.id.sync_text);
        t1.setText(R.string.action_sync);
        t2.setText(R.string.action_sync_text);

        syncButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                Toast.makeText(getApplicationContext(),
                        "Syncing Music to Catalog Now!", Toast.LENGTH_SHORT).show();
                syncCatalog();
                viewJukeboxCatalog();
            }
        });

        syncBackButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                startJukeboxHome();
            }
        });
    }


    /**
     * viewSettingsForm() -- screen displays app settings form
     *
     */
    public void viewSettingsForm()
    {
        //-------------------------------------------------
        // set content view...
        //--------------------------------------------------
        setContentView(R.layout.activity_jukebox_settings);
        toolbar = (Toolbar) findViewById(R.id.toolbar); // we still have a toolbar...
        setSupportActionBar(toolbar);
        //-------------------------------------------------------
        // Init our controls...
        //--------------------------------------------------------
        updateButton         = (Button)findViewById(R.id.update_button);
        settingsCancelButton = (Button)findViewById(R.id.settings_cancel_button);
        editAppContext = (EditText)findViewById(R.id.edit_context);
        editApiUrl     = (EditText)findViewById(R.id.edit_apiurl);
        editAuth       = (EditText)findViewById(R.id.edit_auth);
        //--------------------------------------------------------------
        // Display form with default values...
        //---------------------------------------------------------------
        TextView t1  = (TextView)findViewById(R.id.settings_text);
        t1.setText(R.string.action_settings);
        editAuth.setText(config.getApiAuth());
        editApiUrl.setText(config.getApiUrl());
        editAppContext.setText(config.getString("appcontext"));
        //----------------------------------------------------------
        // Now, override click events for our buttons and edit data.
        //----------------------------------------------------------
        updateButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                if (editAppContext.getText().toString().equals("")
                        || (!editAppContext.getText().toString().equals("true")
                         && !editAppContext.getText().toString().equals("false")))
                {
                    Toast.makeText(getApplicationContext(),
                            "App Context MUST be true or false!", Toast.LENGTH_SHORT).show();
                }
                else if(editApiUrl.getText().toString().equals(""))
                {
                    Toast.makeText(getApplicationContext(),
                            "Must be a valid URL!", Toast.LENGTH_SHORT).show();
                }
                else
                {
                    //----------------------------------------------------
                    // Update and save new config options...
                    //-----------------------------------------------------
                    config.setApiAuth(editAuth.getText().toString());
                    config.putString("APIURL", editApiUrl.getText().toString());
                    config.putString("appcontext", editAppContext.getText().toString());
                    saveConfig();
                    restartJukeboxActivity();
                    //startJukeboxHome();
                }
            }
        });
        settingsCancelButton.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                startJukeboxHome();
            }
        });
    }

    /**
     * doLogin() -- uses API wrapper to login a user and create a session
     *
     */
    public User doLogin()
    {
        return(api.login());
    }

   /**
     * saveConfig() -- save config hash to sqlite database
     *
     */
    public void saveConfig()
    {
        config.setUsername(userUsername);
        config.setPassword(userPassword);
        config.setPasscode(userPasscode);
        jukeboxDB = new DBHelper(this);
        jukeboxDB.updateConfig(config.getApiUrl(),
                               config.getApiAuth(),
                               config.getUsername(),
                               config.getPassword(),
                               config.getPasscode(),
                               config.getString("appcontext"));

    }

    /**
     * initConfig() -- setup configuration object that reads and stores settings in device storage
     *
     */
    public void initConfig()
    {
        config    = new Config(Environment.getExternalStorageDirectory().getPath()+"/jukebox.conf");
        jukeboxDB = new DBHelper(this);

        Cursor rs = jukeboxDB.getData();
        if(rs.getCount() == 0)
        {
            jukeboxDB.insertConfig(config.getApiUrl(),
                                   config.getApiAuth(),
                                   config.getUsername(),
                                   config.getPassword(),
                                   config.getPasscode(),
                                   config.getString("appcontext"));
        }
        else
        {
            rs.moveToFirst();
            config.setApiAuth(rs.getString(rs.getColumnIndex("AUTH")));
            config.setUsername(rs.getString(rs.getColumnIndex("username")));
            config.setPassword(rs.getString(rs.getColumnIndex("password")));
            config.setPasscode(rs.getString(rs.getColumnIndex("passcode")));
            config.putString("APIURL",    rs.getString(rs.getColumnIndex("APIURL")));
            config.putString("appcontext",rs.getString(rs.getColumnIndex("appcontext")));
            //config.putString("APIURL","http://thepeoplesjukebox.com");
            //config.putString("appcontext","true");
        }

        if(!rs.isClosed())
            rs.close();
    }

    /**
     * initApi() -- setup Api wrapper so that it uses a seperate thread to perform http
     *              operations. config object is used to initialize defaults
     *
     */
    public void initApi()
    {
        api = new Api(config.getApiUrl(), config.getApiAuth(), config.getUsername(), config.getPassword());
        api.start();
    }


    //----------------------------------------------------
    // Create DBHelper() class...
    //-----------------------------------------------------
    public class DBHelper extends SQLiteOpenHelper
    {
        private HashMap hp;


        @Override
        public void onCreate(SQLiteDatabase db)
        {
            db.execSQL(
                    "create table  config " +
                            "(APIURL    text, " +
                            " AUTH      text, " +
                            "appcontext text," +
                            "username   text, " +
                            "password   text," +
                            "passcode   text)");
        }

        @Override
        public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)
        {
            db.execSQL("DROP TABLE IF EXISTS config");
            onCreate(db);
        }

        public boolean insertConfig (String apiurl,
                                     String auth,
                                     String username,
                                     String password,
                                     String passcode,
                                     String appcontext)
        {
            SQLiteDatabase db = this.getWritableDatabase();
            ContentValues contentValues = new ContentValues();
            contentValues.put("APIURL",     apiurl);
            contentValues.put("AUTH",       auth);
            contentValues.put("appcontext", appcontext);
            contentValues.put("username",   username);
            contentValues.put("password",   password);
            contentValues.put("passcode",   passcode);
            db.insert("config", null, contentValues);
            return true;
        }


        public boolean updateConfig (String apiurl,
                                     String auth,
                                     String username,
                                     String password,
                                     String passcode,
                                     String appcontext )
        {
            SQLiteDatabase db = this.getWritableDatabase();
            ContentValues contentValues = new ContentValues();
            contentValues.put("APIURL",     apiurl);
            contentValues.put("AUTH",       auth);
            contentValues.put("appcontext", appcontext);
            contentValues.put("username",   username);
            contentValues.put("password",   password);
            contentValues.put("passcode",   passcode);
            db.update("config", contentValues,"appcontext = ?", new String[] {"true"});
            return true;
        }

        public Cursor getData()
        {
            SQLiteDatabase db = this.getReadableDatabase();
            Cursor res =  db.rawQuery( "select * from config",null );
            return res;
        }

        public DBHelper(Context context)
        {
            super(context,"Capstone.db",null,1);
        }
    }

}
