/*---------------------------------------------------------------
Player for DSV Play v. 1.0

--------------------------------------------------------------- */

// Layout and toggle Playlist
const playlist = document.getElementsByClassName('playlist')[0];

// Controls
const controls = document.getElementById('controls');

// Videostreams
var video = document.getElementById('video1'); //Main video stream
video.load();
// Play buttons
var playpausebtn = document.getElementById('play-pause');
const playbackIcons = document.querySelectorAll('.playback-icons use');
const videoContainer = document.getElementById('videocontainer');
var fullscreenbtn = document.getElementById('fullscreen-button');
const fullscreenIcons = fullscreenbtn.querySelectorAll('use');

// Fastforward
var plbackrate = 1;
var ffbtn = document.getElementById('fast-forward');
const fastforwardIcons = document.querySelectorAll('.fastforward-icons use');
var ff15btn = document.getElementById('ff15');
var ff3btn = document.getElementById('ff3');
var ff4btn = document.getElementById('ff4');
var ff5btn = document.getElementById('ff5');
var ff6btn = document.getElementById('ff6');

// Streams
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');

// Progressbars
const progressBar = document.getElementById('progress-bar');
var progressBufferBar = document.getElementById('progress-buffer');
const seek = document.getElementById('seek');
const seekTooltip = document.getElementById('seek-tooltip');

// Volume
const volumeButton = document.getElementById('volume-button');
const volumeIcons = document.querySelectorAll('.volume-button use');
const volumeMute = document.querySelector('use[href="#volume-mute"]');
const volumeLow = document.querySelector('use[href="#volume-low"]');
const volumeHigh = document.querySelector('use[href="#volume-high"]');
const volume = document.getElementById('volume');

// Grid layout
var grid = document.querySelector('.grid');

// Playlist
document.getElementsByClassName('playlist_btn')[0].onclick =
    function (params) {
        if(!playlist.classList.contains('translate')) {
            playlist.classList.add('translate');
        } else {
            playlist.classList.remove('translate');
        }

}


/***************************
 * Function remove elements
 */
function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

Element.prototype.remove = function() {
	this.parentElement.removeChild(this);
};

NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
	for(var i = this.length - 1; i >= 0; i--) {
		if(this[i] && this[i].parentElement) {
			this[i].parentElement.removeChild(this[i]);
		}
	}
};
// Variables used for autodetection of streams
var vstreams = 1;
var gridslave1 = gridslave2 = gridslave3 = 0;

// Master
var gridmaster = 1;
var master = document.getElementById('master');
// Switcher buttons
const master_switcher = document.getElementById('master_switcher');
var master_switchbtn = document.getElementById('master');

// Integrated platform version
/*var newsource_video1 = document.getElementById('video1');*/
var newsource_video2 = document.getElementById('video2');
var newsource_video3 = document.getElementById('video3');
var newsource_video4 = document.getElementById('video4');


/*****************************
 * Check if streams exist
 */

//Check if stream 2 exist
if(newsource_video2)
{
    if(!newsource_video2.getAttribute('src') == "")
    {
        var video2 = document.getElementById('video2');
        video2.load();
        video2.removeAttribute('hidden');
        vstreams++;
        gridslave1 = 1;
        var slave1 = document.getElementById('slave1');
        var slave1_switchbtn = document.getElementById('slave1');
        // Activate Switcher icon
        var slave1_switcher = document.getElementById('slave1_switcher');
        slave1_switcher.classList.toggle('slave1_switcher');
    }
    else {
        document.getElementById("video2").remove();
    }
}

//Check if stream 3 exist
if(newsource_video3)
{
    if( !newsource_video3.getAttribute('src') == ""){
        var video3 = document.getElementById('video3');
        video3.load();
        video3.removeAttribute('hidden');
        vstreams++;
        gridslave2 = 1;
        var slave2 = document.getElementById('slave2');
        var slave2_switchbtn = document.getElementById('slave2');
        // Activate Switcher icon
        var slave2_switcher = document.getElementById('slave2_switcher');
        slave2_switcher.classList.toggle('slave2_switcher');
    }
    else {
        document.getElementById("video3").remove();
    }
}

//Check if stream 4 exist
if(newsource_video4){
    if(  !newsource_video4.getAttribute('src') == ""){
        var video4 = document.getElementById('video4');
        video4.load();
        video4.removeAttribute('hidden');
        vstreams++;
        gridslave3 = 1;
        var slave3 = document.getElementById('slave3');
        var slave3_switchbtn = document.getElementById('slave3');
        // Activate Switcher icon
        var slave3_switcher = document.getElementById('slave3_switcher');
        slave3_switcher.classList.toggle('slave3_switcher');
    }
    else {
        document.getElementById("video4").remove();
    }
}

//Get all streams
var medias = Array.prototype.slice.apply(document.querySelectorAll('audio,video'));

/**************************************
 *
 * Toggle Master Switch grids
 */

//Switch master
var grid_pointer = 0;
var master_click = 0;
var slave1_click = 0;
var slave2_click = 0;
var slave3_click = 0;

/******************************************
/*
/* Check available streams and adjust viewport/grid
/******************************************/
var grid_setup2, grid_setup3, grid_setup4;
// Single stream
if (vstreams === 1) MasterGrid();

/*** If 2 streams are present ***/
// Secondary 1
if (vstreams === 2 && gridslave1 === 1) {
	grid_setup2 = [
	    '"master slave1"  "master slave1" "master slave1" "master slave1" "master slave1" "master slave1"',
        '"slave1 master" "slave1 master" "slave1 master" "slave1 master" "slave1 master" "slave1 master"'];
	/*close2 = 1;
	close3 = 1;*/
	MasterSlaveGrid(0);
}
// Secondary 2
if (vstreams === 2 && gridslave2 === 1) {
    grid_setup2 = [
        '"master slave2"  "master slave2" "master slave2" "master slave2"  "master slave2" "master slave2"',
        '"slave2 master" "slave2 master" "slave2 master" "slave2 master" "slave2 master" "slave2 master"'];
    /*close2 = 1;
    close3 = 1;*/
    MasterSlaveGrid(0);
}
// Secondary 3
if (vstreams === 2 && gridslave3 === 1) {
    grid_setup2 = [
        '"master slave3"  "master slave3" "master slave3" "master slave3"  "master slave3" "master slave3"',
        '"slave3 master" "slave3 master" "slave3 master" "slave3 master" "slave3 master" "slave3 master"'];
   /* close2 = 1;
    close3 = 1;*/
    MasterSlaveGrid(0);
}

/*** If 3 streams are present ***/
// Secondary 1 and 2
if (vstreams === 3 && gridslave1 === 1 && gridslave2 === 1) {
	grid_setup3 = [
	    '"master slave1" "master slave1" "master slave1" "master slave2" "master slave2" "master slave2"',
        '"slave1 master" "slave1 master" "slave1 master" "slave1 slave2" "slave1 slave2" "slave1 slave2"',
        '"slave2 slave1" "slave2 slave1" "slave2 slave1" "slave2 master" "slave2 master" "slave2 master"'];
	/*close3 = 1;*/
	MasterSlave12Grid(0);
}
//Secondary 1 and 3
if (vstreams === 3 && gridslave1 === 1 && gridslave3 === 1) {
    grid_setup3 = [
        '"master slave1" "master slave1" "master slave1" "master slave3" "master slave3" "master slave3"',
        '"slave1 master" "slave1 master" "slave1 master" "slave1 slave3" "slave1 slave3" "slave1 slave3"',
        '"slave3 slave1" "slave3 slave1" "slave3 slave1" "slave3 master" "slave3 master" "slave3 master"'];
    /*close3 = 1;*/
    MasterSlave12Grid(0);
}
//Secondary 2 and 3
if (vstreams === 3 && gridslave2 === 1 && gridslave3 === 1) {
    grid_setup3 = [
        '"master slave2" "master slave2" "master slave2" "master slave3" "master slave3" "master slave3"',
        '"slave2 slave3" "slave2 slave3" "slave2 slave3" "slave2 master" "slave2 master" "slave2 master"',
        '"slave3 master" "slave3 master" "slave3 master" "slave3 slave2" "slave3 slave2" "slave3 slave2"'];
    /*close3 = 1;*/
    MasterSlave12Grid(0);
}

/*** If 4 streams are present ***/

//If all streams are present
if (vstreams === 4) {
	grid_setup4 = [
	    '"master slave1" "master slave1"  "master slave2" "master slave2" "master slave3"  "master slave3"',
        '"slave1 master" "slave1 master" "slave1 slave2" "slave1 slave2" "slave1 slave3" "slave1 slave3"',
        '"slave2 slave1" "slave2 slave1" "slave2 master" "slave2 master" "slave2 slave3" "slave2 slave3"',
        '"slave3 slave1" "slave3 slave1" "slave3 slave2" "slave3 slave2" "slave3 master" "slave3 master"'];
	MasterSlave3Grid(0);
}

function MasterGrid()
{
	grid.style.gridTemplateColumns = '100%';
	grid.style.gridTemplateAreas = '"master" "master" "master" "master" "master" "master"';
}

function MasterSlaveGrid(x)
{
    //Two streams grid
	grid.style.gridTemplateColumns = 'repeat(auto-fill, 70% 30%)';
	grid.style.gridTemplateAreas = grid_setup2[x];
}

function MasterSlave12Grid(x)
{
    //Three streams grid
	grid.style.gridTemplateColumns = 'repeat(auto-fill, 70% 30%)';
	grid.style.gridTemplateAreas = grid_setup3[x];
}
function MasterSlave3Grid(x)
{
    //Four streams grid
    grid.style.gridTemplateColumns = 'repeat(auto-fill, 70% 30%)';
    grid.style.gridTemplateAreas = grid_setup4[x];
}

//Toggler for switching primary stream
function SwitchMaster() {
    // 2 streams
    if (vstreams === 2 && slave1_click === 1) {
        if(grid_pointer === 2) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup2[grid_pointer];
        if(master_click) slave1_click = 0;
    }
    // 3 streams
    if (vstreams === 3 && slave1_click === 1) {
        if(grid_pointer === 2) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup3[grid_pointer];
        if(master_click) slave1_click = 0;
    }
    if (vstreams === 3 && slave2_click === 1) {
        if(grid_pointer === 4) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup3[grid_pointer];
        if(master_click) slave2_click = 0;
    }
    if (vstreams === 3 && slave3_click === 1) {
        if(grid_pointer === 4) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup3[grid_pointer];
        if(master_click) slave1_click = 0;
    }
    // 4 streams
    if (vstreams === 4 && slave1_click === 1) {
        if(grid_pointer === 2) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup4[grid_pointer];
        if(master_click) slave1_click = 0;
    }
    if (vstreams === 4 && slave2_click === 1) {
        if(grid_pointer === 4) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup4[grid_pointer];
        if(master_click) slave2_click = 0;
    }
    if (vstreams === 4 && slave3_click === 1) {
        if(grid_pointer === 6) grid_pointer = 0;
        grid.style.gridTemplateAreas = grid_setup4[grid_pointer];
        if(master_click) slave3_click = 0;
    }

}
//OnClick primary grid
master_switchbtn.onclick = function () {
    if(slave1_click === 0 && slave2_click === 0 && slave3_click === 0) {

    } else {
        if(slave1_click === 1 ) {
                if(slave2_click === 1) {
                    slave2_switcher.classList.toggle('slave2_switcher');
                    slave2_click = 0;
                    grid_pointer = 0;
                }
                if(slave3_click === 1) {
                    slave3_switcher.classList.toggle('slave3_switcher');
                    slave3_click = 0;
                    grid_pointer = 0;
                }
                grid_pointer++;
                slave1_click = 1;
                slave1_switcher.classList.toggle('slave1_switcher');
                master_switcher.classList.toggle('master_switcher');
        }
        if(slave2_click === 1 ) {
                if(slave1_click === 1) {
                    slave1_switcher.classList.toggle('slave1_switcher');
                    slave1_click = 0;
                    grid_pointer = 0;
                }
                if(slave3_click === 1) {
                    slave3_switcher.classList.toggle('slave3_switcher');
                    slave3_click = 0;
                    grid_pointer = 0;
                }
                grid_pointer = grid_pointer + 2;
                slave2_click = 1;
                slave2_switcher.classList.toggle('slave2_switcher');
                master_switcher.classList.toggle('master_switcher');
        }
        if(slave3_click === 1) {
                if(slave1_click === 1) {
                    slave1_switcher.classList.toggle('slave1_switcher');
                    slave1_click = 0;
                    grid_pointer = 0;
                }
                if(slave2_click === 1) {
                    slave2_switcher.classList.toggle('slave2_switcher');
                    slave2_click = 0;
                    grid_pointer = 0;
                }
                grid_pointer = grid_pointer + 3;
                slave3_click = 1;
                slave3_switcher.classList.toggle('slave3_switcher');
                master_switcher.classList.toggle('master_switcher');
        }
        master_click = 1;
        SwitchMaster();
    }

}

// OnClick secondary grids
if(gridslave1 === 1)
{
    slave1_switchbtn.onclick = function () {
        if(slave1_click === 1) {

        } else
        {
            if(slave2_click === 1) {
                slave2_switcher.classList.toggle('slave2_switcher');
                master_switcher.classList.toggle('master_switcher');
                slave2_click = 0;
                grid_pointer = 0;
            }
            if(slave3_click === 1) {
                slave3_switcher.classList.toggle('slave3_switcher');
                master_switcher.classList.toggle('master_switcher');
                slave3_click = 0;
                grid_pointer = 0;
            }

            grid_pointer++;
            slave1_click = 1;
            master_click = 0;
            slave1_switcher.classList.toggle('slave1_switcher');
            master_switcher.classList.toggle('master_switcher');
            SwitchMaster();
        }

    }
}
if(gridslave2 === 1)
{
    slave2_switchbtn.onclick = function () {
        if(slave2_click === 1 ) {

        } else {
            if(slave1_click === 1) {
                slave1_switcher.classList.toggle('slave1_switcher');
                master_switcher.classList.toggle('master_switcher');
                slave1_click = 0;
                grid_pointer = 0;
            }
            if(slave3_click === 1) {
                slave3_switcher.classList.toggle('slave3_switcher');
                master_switcher.classList.toggle('master_switcher');
                slave3_click = 0;
                grid_pointer = 0;
            }

            grid_pointer = grid_pointer + 2;
            slave2_click = 1;
            master_click = 0;
            slave2_switcher.classList.toggle('slave2_switcher');
            master_switcher.classList.toggle('master_switcher');
            SwitchMaster();
        }

    }
}

if(gridslave3 === 1)
{
    slave3_switchbtn.onclick = function () {
        if(slave3_click === 1) {

        } else {
            if (vstreams === 3) {
                if (slave1_click === 1) {
                    slave1_click = 0;
                    grid_pointer = 0;
                }
                grid_pointer = grid_pointer + 2;
                slave3_click = 1;
                SwitchMaster();
            } else {
                if(slave1_click === 1) {
                    slave1_switcher.classList.toggle('slave1_switcher');
                    master_switcher.classList.toggle('master_switcher');
                    slave1_click = 0;
                    grid_pointer = 0;
                }
                if(slave2_click === 1) {
                    slave2_switcher.classList.toggle('slave2_switcher');
                    master_switcher.classList.toggle('master_switcher');
                    slave2_click = 0;
                    grid_pointer = 0;
                }
                grid_pointer = grid_pointer + 3;
                slave3_click = 1;
                master_click = 0;
                // Toggle switcher icon
                master_switcher.classList.toggle('master_switcher');
                slave3_switcher.classList.toggle('slave3_switcher');
                SwitchMaster();
            }
        }

    }
}
//Videoplayer functions

function PlayPause() {

	if(video.paused) {
		playpausebtn.className = 'pause';
        video.play();
	} else {
		playpausebtn.className = 'play';
		video.pause();
	}
}
// updatePlayButton updates the playback icon and tooltip
// depending on the playback state
function updatePlayButton() {
    playbackIcons.forEach(icon => icon.classList.toggle('hidden'));

    if (video.paused) {
        playpausebtn.setAttribute('data-title', 'Spela (s)')
    } else {
        playpausebtn.setAttribute('data-title', 'Pausa (s)')
    }
}

function FastForward() {
    fastforwardIcons.forEach(icon => icon.classList.toggle('hidden'));
	if(video.playbackRate == 1.5 || video.playbackRate == 2 || video.playbackRate == 3 || video.playbackRate == 4 || video.playbackRate == 5 || video.playbackRate == 6){
		ffbtn.className = 'set';
		video.playbackRate = 1;
	} else {
		ffbtn.className = 'back';
		video.playbackRate = plbackrate;
	}

}

function toggleFullscreen(elem) {
    fullscreenIcons.forEach(icon => icon.classList.toggle('hidden'));
	elem = elem || document.documentElement;
	if (!document.fullscreenElement && !document.mozFullScreenElement &&
		!document.webkitFullscreenElement && !document.msFullscreenElement) {
		if (elem.requestFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Avsluta helskärm (h)');
			fullscreenbtn.className = 'close';
			elem.requestFullscreen();
		} else if (elem.msRequestFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Avsluta helskärm (h)');
			fullscreenbtn.className = 'close';
			elem.msRequestFullscreen();
		} else if (elem.mozRequestFullScreen) {
            fullscreenbtn.setAttribute('data-title', 'Avsluta helskärm (h)');
			fullscreenbtn.className = 'close';
			elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Avsluta helskärm (h)');
			fullscreenbtn.className = 'close';
			elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Helskärm (h)');
			fullscreenbtn.className = 'open';
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Helskärm (h)');
			fullscreenbtn.className = 'open';
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
            fullscreenbtn.setAttribute('data-title', 'Helskärm (h)');
			fullscreenbtn.className = 'open';
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
            fullscreenbtn.setAttribute('data-title', 'Helskärm (h)');
			fullscreenbtn.className = 'open';
			document.webkitExitFullscreen();
		}
	}
}


// formatTime takes a time length in seconds and returns the time in minutes and seconds

function formatTime(timeInSeconds) {

    const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

	return {
		minutes: result.substr(3, 2),
		seconds: result.substr(6, 2),
	};


}

// initializeVideo sets the video duration, and maximum value of the progressBar

function initializeVideo() {
	const videoDuration = Math.round(video.duration);
	seek.setAttribute('max', videoDuration);
	progressBar.setAttribute('max', videoDuration);
	const time = formatTime(videoDuration);
	duration.innerText = `${time.minutes}:${time.seconds}`;
	duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}
// updateProgress indicates how far through the video the current playback is by updating the progress bar

function updateProgress() {
	seek.value = Math.floor(video.currentTime);
	progressBar.value = Math.floor(video.currentTime);
}

// updateProgressBuffer indicates how far through the video the current playback has buffered by updating the progress-buffer bar
//ToDo
function updateProgressBuffer() {

    const duration = video.duration;
    if(duration > 0) {
      for(var i = 0; i < video.buffered.length; i++) {
          if(video.buffered.start(video.buffered.length - 1 - i) < video.currentTime) {
              progressBufferBar.style.width = (video.buffered.end(video.buffered.length - 1 -i)/ duration) * 100 + "%";
              break;
          }
      }
    }
    /*if(video.buffered.length > 0) {
        var buffer = video.buffered.end(video.buffered.length - 1);
        progressBufferBar.value = buffer;
    }*/
}
function bufferHandler(e)
{
    if (video && video.buffered && video.buffered.length > 0 && video.buffered.end && video.duration)
    {

        var buffered = e.target.buffered.end(0);
        var duration = e.target.duration;
        var buffered_percentage = (buffered / duration) * 100;
        return buffered_percentage;
    }
}

// updateSeekTooltip uses the position of the mouse on the progress bar

function updateSeekTooltip(event) {
	const skipTo = Math.round((event.offsetX / event.target.clientWidth) * parseInt(event.target.getAttribute('max'), 10));
	seek.setAttribute('data-seek', skipTo)
	const t = formatTime(skipTo);
	seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
	const rect = video.getBoundingClientRect();
	seekTooltip.style.left = `${event.pageX - rect.left}px`;
}

seek.addEventListener('mousemove', updateSeekTooltip);

// skipAhead jumps to a different time in the video

function skipAhead(event) {
	const skipTo = event.target.dataset.seek ? event.target.dataset.seek : event.target.value;
    //Get all streams
    video.currentTime = skipTo;
    if(newsource_video2) video2.currentTime = skipTo;
    if(newsource_video3) video3.currentTime = skipTo;
    if(newsource_video4) video4.currentTime = skipTo;
	progressBar.value = skipTo;
	seek.value = skipTo;
}

video.addEventListener('loadedmetadata', initializeVideo);
seek.addEventListener('input', skipAhead);
// updateTimeElapsed indicates how far through the video the current playback is

function updateTimeElapsed() {
	const time = formatTime(Math.round(video.currentTime));
	timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
	timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

video.addEventListener('timeupdate', updateTimeElapsed);
video.addEventListener('progress', updateProgressBuffer);
video.addEventListener('progress', bufferHandler);
video.addEventListener('timeupdate', updateProgress);

// updateVolume updates the volume

function updateVolume() {
	if (video.muted) {
		video.muted = false;
	}

	video.volume = volume.value;
}

volume.addEventListener('input', updateVolume);

// updateVolumeIcon updates the volume icon

function updateVolumeIcon() {
	volumeIcons.forEach(icon => {
		icon.classList.add('hidden');
	});

	volumeButton.setAttribute('data-title', 'Stäng av ljud (l)')

	if (video.muted || video.volume === 0) {
		volumeMute.classList.remove('hidden');
		volumeButton.setAttribute('data-title', 'Ljud (l)')
	} else if (video.volume > 0 && video.volume <= 0.5) {
		volumeLow.classList.remove('hidden');
	} else {
		volumeHigh.classList.remove('hidden');
	}
}

video.addEventListener('volumechange', updateVolumeIcon);

// toggleMute, mutes or unmutes the video

function toggleMute() {
	video.muted = !video.muted;

	if (video.muted) {
		volume.setAttribute('data-volume', volume.value);
		volume.value = 0;
	} else {
		volume.value = volume.dataset.volume;
	}
}

volumeButton.addEventListener('click', toggleMute);

fullscreenbtn.addEventListener('click', function() {
	toggleFullscreen();
});


playpausebtn.onclick = function (params) {
	PlayPause();
};

ff15btn.onclick = function (M) {
    plbackrate = 1.5;
    FastForward();
}
ffbtn.onclick = function (M) {
    plbackrate = 2;
	FastForward();
}
ff3btn.onclick = function (M) {
    plbackrate = 3;
    FastForward();
}
ff4btn.onclick = function (M) {
    plbackrate = 4;
    FastForward();
}
ff5btn.onclick = function (M) {
    plbackrate = 5;
    FastForward();
}
ff6btn.onclick = function (M) {
    plbackrate = 6;
    FastForward();
}

// AddEventlistners
medias.forEach(function(media) {
	media.addEventListener('play', function(event) {
		medias.forEach(function(media) {
			if(event.target !== media) media.play();
		});
	});
	media.addEventListener('pause', function(event) {
		medias.forEach(function(media) {
			if(event.target !== media) media.pause();
		});
	});
	media.addEventListener('ratechange', function(event) {
		medias.forEach(function(media) {
			if(event.target !== media) media.playbackRate = video.playbackRate;
		});
	});
});

video.addEventListener('timeupdate', function() {
	if(video.ended) {
		playpausebtn.className = "play";
		video.currentTime = 0;
		video.pause();
		video.load();

	}

});
// keyboardShortcuts executes the relevant functions for
// each supported shortcut key
function keyboardShortcuts(event) {
    const { key } = event;
    switch(key) {
        case 's':
            PlayPause();
            break;
        case 'l':
            toggleMute();
            break;
        case 'h':
            toggleFullscreen();
            break;
    }
}
var timeout;

function mouseMovement() {
    showControls();
    timeout = setTimeout(hideControls, 5000);

}

function showControls() {
   controls.style.transform = 'translateY(0)';
}

function hideControls() {
    controls.style.transform = 'translateY(100%) translateY(-5px)';
}

videoContainer.addEventListener('mousemove', mouseMovement);
video.addEventListener('play', updatePlayButton);
video.addEventListener('pause', updatePlayButton);
/*video.addEventListener('click', PlayPause);*/
document.addEventListener('keyup', keyboardShortcuts);


