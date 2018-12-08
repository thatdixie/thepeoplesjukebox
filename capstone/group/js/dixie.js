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



//----------------------------------------------------
// search a jukebox catalog for songs.
//
// Uses REST API call to /search_songs/ with params: 
//
// * jukeboxId
// * searchkey
//---------------------------------------------------
function searchCatalog() {

    //-------------------------------------------------------
    // Here are the parameters we gathered from the form.
    //-------------------------------------------------------
    var jukeboxId= document.getElementById("jukeboxId").value;
    
    //-------------------------------------------------------
    // We're gonna make this section visiable after search
    //-------------------------------------------------------
    var pageSection=document.getElementById("find_song_row");

    //------------------------------------------------------
    // Manufacture a URL that we send to REST API function
    //------------------------------------------------------
    searchUrl ='/capstone/search_song?jukeboxId='+jukeboxId;

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
// * jukeboxId
// * mediaId
//---------------------------------------------------
function pickJukeboxSong(mediaId) {

    //-------------------------------------------------------
    // Here are the parameters we gathered from the form.
    //-------------------------------------------------------
    var jukeboxId= document.getElementById("jukeboxId").value;

    //------------------------------------------------------
    // Manufacture a URL that we send to REST API function
    //------------------------------------------------------
    queueUrl ='/capstone/add_queue?jukeboxId='+jukeboxId+'&mediaId='+mediaId;
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
