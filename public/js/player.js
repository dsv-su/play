// Layout and toggle Playlist
/*
//const SITE = document.querySelector('.site');
const SITE = document.querySelector('.container');
const TRIGGER = document.querySelector('.trigger');
const SHOW = document.querySelector('.playlist');
const MENUITEMS = SHOW.querySelectorAll('nav a');
const MENUARRAY = Array.apply(null, MENUITEMS);
*/
// Videostreams
var video = document.getElementById('video1'); //Main video stream
var progress = document.querySelector('.progress');
var playpausebtn = document.getElementById('play-pause');
var fullscreenbtn = document.getElementById('fullscreen');
var ffbtn = document.getElementById('fast-forward');
var elem = document.documentElement;
//Streams
var vstreams = 1;
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');


// Switch video master
const switchbtn = document.querySelector('.switch');
var grid = document.querySelector('.grid');



/*
// Toggle show class on body element, set aria-expanded

function showMenu() {
    SITE.classList.toggle('show');
	SHOW.classList.add('open');
    TRIGGER.getAttribute('aria-expanded') == 'false' ? TRIGGER.setAttribute('aria-expanded', true) : TRIGGER.setAttribute('aria-expanded', false);
}

// Hide nav area when focus shifts away
function catchFocus() {
	if ( TRIGGER.getAttribute('aria-expanded') == 'true' && !( MENUARRAY.includes(document.activeElement) || document.activeElement === TRIGGER ) ) {
		showMenu();
	} else {
		return;
	}
}

function removeMenu() {
	if ( TRIGGER.getAttribute('aria-expanded') == 'false') {
		SHOW.classList.remove('open');
	}
}

// Hide nav area when touch or click happens elsewhere:
function clickTarget(e) {
	if ( TRIGGER.getAttribute('aria-expanded') == 'true' && !SHOW.contains(e.target) ) {
		showMenu();
	}
}

// Listen for clicks on TRIGGER button
TRIGGER.addEventListener('click', showMenu, false);

// Listen for focus changes
SITE.addEventListener('focusin', catchFocus, true);

// Listen for clicks
SITE.addEventListener('click', function(e) { clickTarget(e); }, true);

SITE.addEventListener('transitionend', removeMenu, false);

*/
// Videostreams

/**************************
 *
 * @type {URLSearchParams}
 */

function getUrlParameter(name) {
	name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
	var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
	var results = regex.exec(location.search);
	return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

/***************************
 * Function to remove elements
 */

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

/*****************************
 * Change stream source
 * @type {string}
 */

var newsource_video1 = getUrlParameter('source1');
var newsource_video2 = getUrlParameter('source2');
var newsource_video3 = getUrlParameter('source3');
var newsource_video4 = getUrlParameter('source4');

video.setAttribute('src', newsource_video1);

//Check if stream 2 exist
if( newsource_video2){
	var video2 = document.getElementById('video2');
	video2.removeAttribute('hidden');
	video2.setAttribute('src', newsource_video2);
	vstreams++;
}
else {
	document.getElementById("video2").remove();
}
//Check if stream 3 exist
if( newsource_video3){
	var video3 = document.getElementById('video3');
	video3.removeAttribute('hidden');
	video3.setAttribute('src', newsource_video3);
	vstreams++;
}
else {
	document.getElementById("video3").remove();
}
//Check if stream 4 exist
if( newsource_video4){
	var video4 = document.getElementById('video4');
	video4.removeAttribute('hidden');
	video4.setAttribute('src', newsource_video4);
	vstreams++;
}
else {
	document.getElementById("video4").remove();
}
//Get all streams
var medias = Array.prototype.slice.apply(document.querySelectorAll('audio,video'));

/******************************************
/*
/* Check available streams and adjust viewport
/******************************************/

// Single stream
if (vstreams == 1)
{
	grid.style.gridTemplateColumns = '100%';
	grid.style.gridTemplateAreas = '"master master" "master master" "master master"';
	document.getElementsByClassName("slave1").remove();
	document.getElementsByClassName("slave2").remove();
	document.getElementsByClassName("slave3").remove();
}
// 2 streams
if (vstreams == 2)
{
	grid.style.gridTemplateColumns = '50% 50%';
	grid.style.gridTemplateAreas = '"master slave1" "master slave1" "master slave1"';
	document.getElementsByClassName("slave2").remove();
	document.getElementsByClassName("slave3").remove();
}
// 3 streams
if (vstreams == 3)
{
	grid.style.gridTemplateColumns = '50% 50%';
	grid.style.gridTemplateAreas = '"master slave1" "master slave1" "master slave2"';
	document.getElementsByClassName("slave3").remove();
}


//Switch master
var grid_pointer = 0;
grid_pointer++;

//If 2 streams are present
if (vstreams == 2) {
	var grid_setup2 = ['"master slave1" "master slave1" "master slave1"', '"slave1 master" "slave1 master" "slave1 master"'];
}
//If 3 streams are present
if (vstreams == 3) {
	var grid_setup3 = ['"master slave1" "master slave1" "master slave2"', '"slave1 slave2" "slave1 slave2" "slave1 master"', '"slave2 master" "slave2 master" "slave2 slave1"'];
}
//If all streams are present
if (vstreams == 4) {
	var grid_setup = ['"master slave1" "master slave2" "master slave3"', '"slave1 slave2" "slave1 slave3" "slave1 master"', '"slave2 slave3" "slave2 master" "slave2 slave1"','"slave3 master" "slave3 slave1" "slave3 slave2"'];
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
function FastForward() {
	if(video.playbackRate == 2){
		ffbtn.className = 'set';
		video.playbackRate = 1;
	} else {
		ffbtn.className = 'back';
		video.playbackRate = 2;
	}

}

function SwitchMaster() {
	if (vstreams == 2) {
		grid.style.gridTemplateAreas = grid_setup2[grid_pointer];
		grid_pointer++;
		if(grid_pointer == 2) grid_pointer = 0;
	}
	if (vstreams == 3) {
		grid.style.gridTemplateAreas = grid_setup3[grid_pointer];
		grid_pointer++;
		if(grid_pointer == 3) grid_pointer = 0;
	}
	if (vstreams == 4) {
		grid.style.gridTemplateAreas = grid_setup[grid_pointer];
		grid_pointer++;
		if(grid_pointer == 4) grid_pointer = 0;
	}


}

function toggleFullscreen(elem) {
	elem = elem || document.documentElement;
	if (!document.fullscreenElement && !document.mozFullScreenElement &&
		!document.webkitFullscreenElement && !document.msFullscreenElement) {
		if (elem.requestFullscreen) {
			fullscreenbtn.className = 'close';
			elem.requestFullscreen();
		} else if (elem.msRequestFullscreen) {
			fullscreenbtn.className = 'close';
			elem.msRequestFullscreen();
		} else if (elem.mozRequestFullScreen) {
			fullscreenbtn.className = 'close';
			elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
			fullscreenbtn.className = 'close';
			elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	} else {
		if (document.exitFullscreen) {
			fullscreenbtn.className = 'open';
			document.exitFullscreen();
		} else if (document.msExitFullscreen) {
			fullscreenbtn.className = 'open';
			document.msExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			fullscreenbtn.className = 'open';
			document.mozCancelFullScreen();
		} else if (document.webkitExitFullscreen) {
			fullscreenbtn.className = 'open';
			document.webkitExitFullscreen();
		}
	}
}


// formatTime takes a time length in seconds and returns the time in
// minutes and seconds
function formatTime(timeInSeconds) {
	const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

	return {
		minutes: result.substr(3, 2),
		seconds: result.substr(6, 2),
	};
};
// initializeVideo sets the video duration, and maximum value of the
// progressBar

function initializeVideo() {
	const videoDuration = Math.round(video.duration);
	const time = formatTime(videoDuration);
	duration.innerText = `${time.minutes}:${time.seconds}`;
	duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

video.addEventListener('loadedmetadata', initializeVideo);

// updateTimeElapsed indicates how far through the video
// the current playback is
function updateTimeElapsed() {
	const time = formatTime(Math.round(video.currentTime));
	timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
	timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

video.addEventListener('timeupdate', updateTimeElapsed);


fullscreenbtn.addEventListener('click', function() {
	toggleFullscreen();
});


playpausebtn.onclick = function (params) {
	PlayPause();
};
ffbtn.onclick = function (M) {
	FastForward();
}

switchbtn.onclick = function () {
	SwitchMaster();
}


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
	var progressPos = video.currentTime / video.duration;
	progress.style.width = progressPos * 100 + "%";
	if(video.ended) {
		playpausebtn.className = "play";
		video.currentTime = 0;
		video.pause();
		video.load();

	}

});
