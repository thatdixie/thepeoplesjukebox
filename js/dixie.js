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


//-------------------------------------------
// This function plays the jukebox -- it's
// a work in progres lol 
//-------------------------------------------
function playSound(el,soundfile) {
    if (el.mp3) {
        if (el.mp3.paused) {
           //el.mp3 = new Audio(soundfile);
            el.mp3.load();
            el.mp3.play();
	}
        else if (el.mp3.ended) {
            //el.mp3.load();
            el.mp3.play();
	}
        else {
            el.mp3.pause();
	}
    }
    else {   
    soundfile = soundfile+'&bust='+new Date().getTime();
        el.mp3 = new Audio(soundfile);        
        //el.mp3.loop = false;
        //el.mp3.load();
        el.mp3.play();
    }
}

