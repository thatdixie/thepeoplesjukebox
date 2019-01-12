//-------------------------------------------
// keeps standalone web-app from launching
// new safari on links
//-------------------------------------------
// by https://github.com/irae
(function(document,navigator,standalone) {
    // prevents links from apps from oppening in mobile safari
    // this javascript must be the first script in your <head>
    if ((standalone in navigator) && navigator[standalone]) {
	var curnode, location=document.location, stop=/^(a|html)$/i;
	document.addEventListener('click', function(e) {
	    curnode=e.target;
	    while (!(stop).test(curnode.nodeName)) {
		curnode=curnode.parentNode;
	    }
	    // Condidions to do this only on links to your own app
	    // if you want all links, use if('href' in curnode) instead.
	    if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
		e.preventDefault();
		location.href = curnode.href;
	    }
	},false);
    }
})(document,window.navigator,'standalone');

//------------------------------------
// global page scope vars for jukebox
//------------------------------------
page = null;
username ='';
passcode ='';
jukeboxId=0;
URL ='';
file='';
semaphore =0;
select ='no';

//-----------------------------------------------------------------------------------
// Plays current or next song on iPhone
//
// soundfile is created by manually manufacturing /mp3player/mp3player.php URL
// since waiting for callback creates a race condition and iphone disables play
// from inside a callback (becasue Apple is EVIL) and play MUST result from a user
// click...
//------------------------------------------------------------------------------------
function playOnIphone(p, u, pc, jb)
{
    page=p;
    username=u;
    passcode=pc;
    jukeboxId=jb;
    
    //--------------------------------------------------------
    // you can only select playnext if you're the jukebox.
    // mp3IphonePlayer.php knows this.
    // As does the REST API...
    //--------------------------------------------------------
    userId   = document.getElementById("userId").value;
    soundfile ='http://thepeoplesjukebox.com/mp3player/mp3IphonePlayer.php?jukeboxId='+jukeboxId+'&userId='+userId;

    //--------------------------------------------------------
    // We use the API to get currently playing information.
    //--------------------------------------------------------
    URL='/api/play_next?username='+username+'&passcode='+passcode+'&jukeboxId='+jukeboxId;
    $.getJSON(URL, function(media) {
        document.getElementById("currently_playing").innerHTML =media.mediaTitle+" -- "+media.mediaArtist;
    });
    
    if(page.mp3)
    {
        //page.mp3.pause();
        //page.mp3  = null;
        //page.mp3  = new Audio(soundfile);
        //page.mp3.loop = false;
 	//page.mp3.play();
//        page.currentTime =0;
    }
    else
    {	
        page.mp3  = new Audio(soundfile);
        page.currentTime =0;
        page.mp3.loop = false;
        page.mp3.play();
    }
}


//-------------------------------------------
// This function plays the next song on
// a jukebox -- uses API request play_next 
//-------------------------------------------
function playNextSong(p, u, pc, jb) {

    //---------------------------------------------
    // check to see if this is an iphone...
    //---------------------------------------------
    if(document.getElementById("iphone_container") != null)
    {
	playOnIphone(p,u,pc,jb);
	return;
    }
    //-----------------------------------------------
    // if not iPhone we use the REST API normally...
    //-----------------------------------------------
    page=p;
    username=u;
    passcode=pc;
    jukeboxId=jb;
    URL='/api/play_next?username='+username+'&passcode='+passcode+'&jukeboxId='+jukeboxId;
    
    if (page.mp3) {
        page.mp3.pause();
	page.mp3 = null;
        $.getJSON(URL, function(media) {
            file = media.mediaFile+'&bust='+new Date().getTime();
            page.mp3 = new Audio(file);
            page.mp3.loop = false;
 	    page.mp3.play();
            document.getElementById("currently_playing").innerHTML =media.mediaTitle+" -- "+media.mediaArtist;
            page.mp3.addEventListener("ended", function(e) {
	        songEnded();
	    });
        });
    }
    else {   
        $.getJSON(URL, function(media) {
            file = media.mediaFile+'&bust='+new Date().getTime();
	    page.mp3 = new Audio(file);
            page.mp3.loop = false;
 	    page.mp3.play();
            document.getElementById("currently_playing").innerHTML =media.mediaTitle+" -- "+media.mediaArtist;
            page.mp3.addEventListener("ended", function(e) {
	        songEnded();	
	    });
        });
    }
}

//-----------------------------------------------
// This function is the callback that's called
// when a song ends -- it calls playNextSong() 
// again creating an endless play loop
//-----------------------------------------------
function songEnded() {

    playNextSong(page, username, passcode, jukeboxId);
}

//----------------------------------------------------
// search a jukebox catalog for songs.
//
// Uses REST API call to /search_songs/ with params: 
//
// * username
// * passcode
// * jukeboxId
// * searchkey
//---------------------------------------------------
function searchCatalog() {

    //-------------------------------------------------------
    // Here are the parameters we gathered from the form.
    //-------------------------------------------------------
    var username = document.getElementById("username").value;
    var passcode = document.getElementById("passcode").value;
    var jukeboxId= document.getElementById("jukeboxId").value;
    var searchKey= document.getElementById("formSearchKey").value;
    
    //-------------------------------------------------------
    // We're gonna make this section visiable after search
    //-------------------------------------------------------
    var pageSection=document.getElementById("find_song_row");

    //------------------------------------------------------
    // Manufacture a URL that we send to REST API function
    //------------------------------------------------------
    searchUrl ='/api/search_song?username='+username+
	                       '&passcode='+passcode+
	                       '&jukeboxId='+jukeboxId+
	                       '&searchKey='+searchKey;

    songList = document.getElementById("jukebox_catalog_list");
    songList.innerHTML="";
    
    $.getJSON(searchUrl, function(songs) {
        if(songs != null)
	{
            var l = songs.length;
            if(l!= 0)
            {
                pageSection.style.visibility='visible';
                for(i=0; i < l; i++)
	        {
	            songList.innerHTML+="<tr><td>"+songs[i].mediaTitle+
		                       "</td><td>"+songs[i].mediaArtist+
		        "</td><td>"+songs[i].mediaSource+
		        "</td><td><a href=\"javascript:pickJukeboxSong("+songs[i].mediaId+");\">Select</a></td></tr>";
	        }
	    }
	}
	else
	{
            alert("Oops! we had a problem! Try Again!");	    
	}
    });
}

//----------------------------------------------------
// Request to play a song on a jukbox.
//
// Uses REST API call to /add_queue/ with params: 
//
// * username
// * passcode
// * jukeboxId
// * mediaId
//---------------------------------------------------
function pickJukeboxSong(mediaId) {

    if(mediaId==0)
	return;
    
    //-------------------------------------------------------
    // Here are the parameters we gathered from the form.
    //-------------------------------------------------------
    var username = document.getElementById("username").value;
    var passcode = document.getElementById("passcode").value;
    var jukeboxId= document.getElementById("jukeboxId").value;

    //------------------------------------------------------
    // Manufacture a URL that we send to REST API function
    //------------------------------------------------------
    queueUrl ='/api/add_queue?username='+username+
	                       '&passcode='+passcode+
	                       '&jukeboxId='+jukeboxId+
	                       '&mediaId='+mediaId;
    $.getJSON(queueUrl, function(playlist) {
	if(playlist != null)
	{
            if(playlist.playlistStatus == 'PLAY_LIMIT')
	    {
                alert("You've already added "+playlist.playlistOrder+" songs!");
	    }
	    else
	    {
		order = playlist.playlistOrder-1;
                alert("Your song is number "+order+" in the list!");	    
	    }
	}
	else
	{
            alert("Oops! we had a problem! Try Again!");
	}
    });
}


//----------------------------------------------------
// search for Jukebox profiles.
//
// Uses REST API call to /search_profile/ with params: 
//
// * username
// * passcode
// * searchkey
//---------------------------------------------------
function searchProfile() {

    //-------------------------------------------------------
    // Here are the parameters we gathered from the form.
    //-------------------------------------------------------
    var username = document.getElementById("username").value;
    var passcode = document.getElementById("passcode").value;
    var searchKey= document.getElementById("formSearchKey").value;
    
    //-------------------------------------------------------
    // We're gonna make this section visiable after search
    //-------------------------------------------------------
    var pageSection=document.getElementById("find_profile_row");

    //------------------------------------------------------
    // Manufacture a URL that we send to REST API function
    //------------------------------------------------------
    searchUrl ='/api/search_profile?username='+username+
	                          '&passcode='+passcode+
	                          '&searchKey='+searchKey;

    userList = document.getElementById("jukebox_profile_list");
    userList.innerHTML="";
    
    $.getJSON(searchUrl, function(users) {
        if(users != null)
	{
            var l = users.length;
            if(l!= 0)
            {
                pageSection.style.visibility='visible';
                for(i=0; i < l; i++)
	        {
	            userList.innerHTML+="<tr><td>"+users[i].nickName+" ("+users[i].firstName+" "+users[i].lastName+")"+
		                       "</td><td>"+users[i].likes+
		        "</td><td>"+users[i].workplace+
		        "</td><td><a href=\"/user/index?func=player&jukeboxId="+users[i].userId+"\">Go to Jukebox</a></td></tr>";
	        }
	    }
	}
	else
	{
            alert("Oops! we had a problem! Try Again!");	    
	}
    });
}


//-------------------------------------
// Waits on getJSON callback completion
//-------------------------------------
async function getJSONWait() {

    semaphore =1;
    
    while(semaphore)	
        await sleep(1000);
}

//----------------------------
// signals waiting thread...
//----------------------------
function getJSONSignal() {

    semaphore =0;
}

//-----------------------------------------
// sleep function uses brand new promises
// ----------------------------------------
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
