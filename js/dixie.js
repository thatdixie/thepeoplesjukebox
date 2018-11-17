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

//-------------------------------------------
// This function plays the next song on
// a jukebox -- uses API request play_next 
//-------------------------------------------
function playNextSong(p, u, pc, jb) {

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
    $.getJSON(queueUrl, function() {
        alert("Song request sent!");
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
