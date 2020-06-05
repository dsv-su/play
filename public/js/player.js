//Dev mode
const streamsOutput = document.querySelector('#streams');
// Layout and toggle Playlist
const SITE = document.querySelector('.grid');
const TRIGGER = document.querySelector('.trigger');
const SHOW = document.querySelector('.playlist');
const MENUITEMS = SHOW.querySelectorAll('nav a');
const MENUARRAY = Array.apply(null, MENUITEMS);
const closebtn = document.getElementById('player_close');

// Videostreams
var video = document.getElementById('video1'); //Main video stream
var playpausebtn = document.getElementById('play-pause');
var fullscreenbtn = document.getElementById('fullscreen');

// Fastforward
var plbackrate = 1;
var ffbtn = document.getElementById('fast-forward');
var ff3btn = document.getElementById('ff3');
var ff4btn = document.getElementById('ff4');
var ff5btn = document.getElementById('ff5');
var ff6btn = document.getElementById('ff6');

// Streams
var vstreams = 1;
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');

// Progressbar
const progressBar = document.getElementById('progress-bar');
const seek = document.getElementById('seek');
const seekTooltip = document.getElementById('seek-tooltip');

// Volume
const volumeButton = document.getElementById('volume-button');
const volumeIcons = document.querySelectorAll('.volume-button use');
const volumeMute = document.querySelector('use[href="#volume-mute"]');
const volumeLow = document.querySelector('use[href="#volume-low"]');
const volumeHigh = document.querySelector('use[href="#volume-high"]');
const volume = document.getElementById('volume');

// Switch video master
const switchbtn = document.querySelector('.switch');
var grid = document.querySelector('.grid');

// Switch disable slave
const slave1 = document.getElementById('slave1');
const slave1_switchbtn = document.getElementById('disable_slave1');
const slave2 = document.getElementById('slave2');
const slave2_switchbtn = document.getElementById('disable_slave2');
const slave3 = document.getElementById('slave3');
const slave3_switchbtn = document.getElementById('disable_slave3');
var close1 = 0, close2 = 0, close3 = 0;

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

/***************************
 * Function remove elements
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

// Integrated laravel version
var newsource_video1 = document.getElementById('video1').src;
var newsource_video2 = document.getElementById('video2').src;
var newsource_video3 = document.getElementById('video3').src;
var newsource_video4 = document.getElementById('video4').src;

/*****************************
 * Check if streams exist
 */

//Check if stream 2 exist
if( newsource_video2){
	var video2 = document.getElementById('video2');
	video2.removeAttribute('hidden');
	vstreams++;
}
else {
	document.getElementById("video2").remove();
}
//Check if stream 3 exist
if( newsource_video3){
	var video3 = document.getElementById('video3');
	video3.removeAttribute('hidden');
	vstreams++;
}
else {
	document.getElementById("video3").remove();
}
//Check if stream 4 exist
if( newsource_video4){
	var video4 = document.getElementById('video4');
	video4.removeAttribute('hidden');
	vstreams++;
}
else {
	document.getElementById("video4").remove();
}

//Get all streams
var medias = Array.prototype.slice.apply(document.querySelectorAll('audio,video'));

/**************************************
 *
 * Toggle Master Switch grids
 */

//Switch master
var grid_pointer = 0;
grid_pointer++;

/******************************************
/*
/* Check available streams and adjust viewport/grid
/******************************************/

// Single stream
if (vstreams == 1) MasterGrid();

//If 2 streams are present
if (vstreams == 2) {
	var grid_setup2 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1"', '"nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master"'];
	close2 = 1;
	close3 = 1;
	MasterSlaveGrid();
}
//If 3 streams are present
if (vstreams == 3) {
	var grid_setup3 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave2" "nav master slave2" "nav master slave2"', '"nav slave1 slave2" "nav slave1 slave2" "nav slave1 slave2" "nav slave1 master" "nav slave1 master" "nav slave1 master"', '"nav slave2 master" "nav slave2 master" "nav slave2 master" "nav slave2 slave1" "nav slave2 slave1" "nav slave2 slave1"'];
	close3 = 1;
	MasterSlave12Grid();
}
//If all streams are present
if (vstreams == 4) {
	var grid_setup = ['"nav master slave1" "nav master slave1"  "nav master slave2" "nav master slave2" "nav master slave3" "nav master slave3"', '"nav slave1 slave2" "nav slave1 slave2" "nav slave1 slave3" "nav slave1 slave3" "nav slave1 master" "nav slave1 master"', '"nav slave2 slave3" "nav slave2 slave3" "nav slave2 master" "nav slave2 master" "nav slave2 slave1" "nav slave2 slave1"','"nav slave3 master" "nav slave3 master" "nav slave3 slave1" "nav slave3 slave1" "nav slave3 slave2" "nav slave3 slave2"'];
//Dev mode
	streamsOutput.textContent = vstreams;
}

function MasterGrid()
{
	grid.style.gridTemplateColumns = '15em 100%';
	grid.style.gridTemplateAreas = '"nav master master" "nav master master" "nav master master" "nav master master" "nav master master" "nav master master"';
	slave1.style.display = 'none';
	slave2.style.display = 'none';
	slave3.style.display = 'none';
	switchbtn.remove();
	vstreams = 1;
	//Dev mode
	streamsOutput.textContent = vstreams;
}

function MasterSlaveGrid()
{
	grid.style.gridTemplateColumns = '15em 50% 50%';
	grid.style.gridTemplateAreas = '"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1"';
	slave2.style.display = 'none';
	slave3.style.display = 'none';
	vstreams = 2;
	grid_setup2 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1"', '"nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master"'];

	//Dev mode

	streamsOutput.textContent = vstreams;
}
function MasterSlave1Grid()
{
	grid.style.gridTemplateColumns = '15em 50% 50%';
	grid.style.gridTemplateAreas = '"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1"';
	if (close2 == 1) slave2.style.display = 'none';
	if (close3 == 1) slave3.style.display = 'none';
	vstreams = 2;
	grid_setup2 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1" "nav master slave1"', '"nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master" "nav slave1 master"'];

	//Dev mode
	streamsOutput.textContent = vstreams;
}

function MasterSlave12Grid()
{
	grid.style.gridTemplateColumns = '15em 67% 33%';
	grid.style.gridTemplateAreas = '"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave2" "nav master slave2" "nav master slave2"';
	slave3.style.display = 'none';
	vstreams = 3;
	grid_setup3 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave2" "nav master slave2" "nav master slave2"', '"nav slave1 slave2" "nav slave1 slave2" "nav slave1 slave2" "nav slave1 master" "nav slave1 master" "nav slave1 master"', '"nav slave2 master" "nav slave2 master" "nav slave2 master" "nav slave2 slave1" "nav slave2 slave1" "nav slave2 slave1"']

	//Dev mode
	streamsOutput.textContent = vstreams;
}
function MasterSlave2Grid()
{
	grid.style.gridTemplateColumns = '15em 50% 50%';
	grid.style.gridTemplateAreas = '"nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2"';
	if( close3 == 1) slave3.style.display = 'none';
	if (close1 == 1) slave1.style.display = 'none';
	vstreams = 2;
	grid_setup2 = ['"nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2" "nav master slave2"', '"nav slave2 master" "nav slave2 master" "nav slave2 master" "nav slave2 master" "nav slave2 master" "nav slave2 master"'];

	//Dev mode
	streamsOutput.textContent = vstreams;
}
function MasterSlave3Grid()
{
	grid.style.gridTemplateColumns = '15em 50% 50%';
	grid.style.gridTemplateAreas = '"nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3"';
	if( close2 == 1) slave2.style.display = 'none';
	if (close1 == 1) slave1.style.display = 'none';
	vstreams = 2;
	grid_setup2 = ['"nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3" "nav master slave3"', '"nav slave3 master" "nav slave3 master" "nav slave3 master" "nav slave3 master" "nav slave3 master" "nav slave3 master"'];

	//Dev mode
	streamsOutput.textContent = vstreams;
}
function MasterSlave13Grid()
{
	grid.style.gridTemplateColumns = '15em 67% 33%';
	grid.style.gridTemplateAreas = '"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave3" "nav master slave3" "nav master slave3"';
	slave2.style.display = 'none';
	vstreams = 3;
	grid_setup3 = ['"nav master slave1" "nav master slave1" "nav master slave1" "nav master slave3" "nav master slave3" "nav master slave3"', '"nav slave1 slave3" "nav slave1 slave3" "nav slave1 slave3" "nav slave1 master" "nav slave1 master" "nav slave1 master"', '"nav slave3 master" "nav slave3 master" "nav slave3 master" "nav slave3 slave1" "nav slave3 slave1" "nav slave3 slave1"']

	//Dev mode
	streamsOutput.textContent = vstreams;
}
function MasterSlave23Grid()
{
	grid.style.gridTemplateColumns = '15em 67% 33%';
	grid.style.gridTemplateAreas = '"nav master slave2" "nav master slave2" "nav master slave2" "nav master slave3" "nav master slave3" "nav master slave3"';
	slave1.style.display = 'none';
	vstreams = 3;
	grid_setup3 = ['"nav master slave2" "nav master slave2" "nav master slave2" "nav master slave3" "nav master slave3" "nav master slave3"', '"nav slave2 slave3" "nav slave2 slave3" "nav slave2 slave3" "nav slave2 master" "nav slave2 master" "nav slave2 master"', '"nav slave3 master" "nav slave3 master" "nav slave3 master" "nav slave3 slave2" "nav slave3 slave2" "nav slave3 slave2"']

	//Dev mode
	streamsOutput.textContent = vstreams;
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
	if(video.playbackRate == 2 || video.playbackRate == 3 || video.playbackRate == 4 || video.playbackRate == 5 || video.playbackRate == 6){
		ffbtn.className = 'set';
		video.playbackRate = 1;
	} else {
		ffbtn.className = 'back';
		video.playbackRate = plbackrate;
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

//Disable slave button
function disableSlave1()
{
	if (close2 == 1 && close3 == 1) MasterGrid();
	else if( close2 == 1) MasterSlave3Grid();
	else if ( close3 == 1)  MasterSlave2Grid();
	else  MasterSlave23Grid();
}
function disableSlave2()
{
	if (close1 == 1 && close3 == 1) MasterGrid();
	else if( close1 == 1) MasterSlave3Grid();
	else if(close3 == 1) MasterSlave1Grid();
	else MasterSlave13Grid();
}
function disableSlave3() {
	if (close1 == 1 && close2 == 1) MasterGrid();
	else if (close1 == 1)  MasterSlave2Grid();
	else if (close2 == 1) 	MasterSlave1Grid();
	else  MasterSlave12Grid();
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


// formatTime takes a time length in seconds and returns the time in minutes and seconds

function formatTime(timeInSeconds) {
	const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

	return {
		minutes: result.substr(3, 2),
		seconds: result.substr(6, 2),
	};
};

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
    if( newsource_video2) video2.currentTime = skipTo;
    if( newsource_video3) video3.currentTime = skipTo;
    if( newsource_video4) video4.currentTime = skipTo;
	progressBar.value = skipTo;
	seek.value = skipTo;
}
seek.addEventListener('input', skipAhead);

video.addEventListener('loadedmetadata', initializeVideo);

// updateTimeElapsed indicates how far through the video the current playback is

function updateTimeElapsed() {
	const time = formatTime(Math.round(video.currentTime));
	timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
	timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

video.addEventListener('timeupdate', updateTimeElapsed);
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

	volumeButton.setAttribute('data-title', 'Mute (m)')

	if (video.muted || video.volume === 0) {
		volumeMute.classList.remove('hidden');
		volumeButton.setAttribute('data-title', 'Unmute (m)')
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

switchbtn.onclick = function () {
	SwitchMaster();
}
closebtn.onclick = function () {
    location.replace("/")
}
slave1_switchbtn.onclick = function () {
	close1++;
	disableSlave1();
}
slave2_switchbtn.onclick = function () {
	close2++;
	disableSlave2();
}
slave3_switchbtn.onclick = function () {
	close3++;
	disableSlave3();
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
	if(video.ended) {
		playpausebtn.className = "play";
		video.currentTime = 0;
		video.pause();
		video.load();

	}

});
