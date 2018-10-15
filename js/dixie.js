
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

