document.addEventListener('DOMContentLoaded', init)

function init() {
    var body = document.querySelector('body')
    var mainstream = document.querySelector('.main > video')
    setupLoader(mainstream)
    
    var [presentation, playlist] = getArgs()
    var read = new XMLHttpRequest()
    read.addEventListener('load', function() {
        var data = JSON.parse(read.responseText)

        body.dataset.id = data.id
        loadStreams(data.sources, mainstream)

        if(playlist) {
            setupPlaylist(body, playlist)
        }
        
        function awaitLoad(callback) {
            var loaded = 0
            var streams = document.querySelectorAll('video')
            streams.forEach(function(stream) {
                stream.addEventListener('loadedmetadata', function(event) {
                    loaded += 1
                    if(loaded === streams.length) {
                        callback()}})})
            
            setupHiding(body, mainstream)
            setupAbout(data.title)
            setupBlur()
            setupSpeed()
            setupFullscreen()
            setupVolume(mainstream)
            setupSwitching(mainstream)
            setupSync(mainstream)
            setupPlayback(body, mainstream)
            // TODO: implement subs
            // setupSubs(data.subtitles, mainstream)
        }
        awaitLoad(function() {
            setupBuffer(mainstream)
            setupProgress(body, mainstream)
        })
    })
    read.open('GET', presentation)
    read.send()
}

function getArgs() {
    var get = window.location.search.substring(1)
    var data, playlist
    get.split('&').forEach(function(arg) {
        [name, value] = arg.split('=')
        switch(name) {
        case 'presentation':
        case 'play':
        case 'show':
        case 'p':
        case 's':
            data = value
            break
        case 'playlist':
        case 'list':
        case 'l':
            playlist = value
            break
        }
    })
    return [data, playlist]
}

function loadStreams(streamlist, mainstream) {
    var mainparent = mainstream.parentNode
    var template = document.getElementById('stream-template')

    var main = streamlist[0]
    
    mainstream.src = main.video
    mainstream.muted = !main.audio
    mainstream.poster = main.poster
    mainstream.load()
    mainstream.preload = 'auto'
    for (var i = 1; i < streamlist.length; i++) {
        var newstream = template.content.cloneNode(true)
        var video = newstream.querySelector('video')
        video.src = streamlist[i].video
        video.muted = !streamlist[i].audio
        video.poster = streamlist[i].poster
        video.load()
        video.preload = 'auto'
        mainparent.parentNode.insertBefore(newstream, mainparent.nextSibling)
    }
}

function setupAbout(title) {
    document.querySelectorAll('title, #title')
        .forEach(function(elem) {
            elem.textContent = title})
}

function setupBlur() {
    document.querySelectorAll('button, input, video')
        .forEach(function(elem) {
            elem.addEventListener('click', function(event) {
                event.currentTarget.blur()})})
}

function setupBuffer(mainstream) {
    var needsUpdate = false
    var color = window.getComputedStyle(document.querySelector(':root'))
        .getPropertyValue('--foreground')
    var buffer = document.querySelector('#buffer')

    function paintBuffer() {
        if(needsUpdate) {
            buffer.width = buffer.clientWidth
            buffer.height = buffer.clientHeight

            var context = buffer.getContext('2d')
            context.clearRect(0, 0, buffer.width, buffer.height)
            context.fillStyle = color
            context.strokeStyle = color

            var inc = buffer.width / mainstream.duration
            var buffered = mainstream.buffered
            for(var i = 0; i < buffered.length; i++) {
                var start = buffered.start(i) * inc
                var end = buffered.end(i) * inc
                var width = end - start
                context.fillRect(start, 0, width, buffer.height)
            }
            needsUpdate = false
        }
        requestAnimationFrame(paintBuffer)
    }
    function flagUpdate(event) {
        needsUpdate = true
    }
    mainstream.addEventListener('progress', flagUpdate)
    window.addEventListener('resize', flagUpdate)
    window.requestAnimationFrame(paintBuffer)
}

function setupFullscreen() {
    var body = document.querySelector('body')
    var icons = document.querySelectorAll('#fullscreen-button > svg > use')
    
    function toggleFullscreen(event) {
        if(document.fullscreenElement) {
            document.exitFullscreen()
        } else {
            body.requestFullscreen()
        }
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
    }

    var button = document.querySelector('#fullscreen-button')
    button.addEventListener('click', toggleFullscreen)
}

function setupHiding(body, mainstream) {
    const selector = 'nocursor'
    var timer = window.setTimeout(hide, 1500)
    var controls = document.querySelector('#controls')
    var about = document.querySelector('#about')
    
    function hide() {
        if(!body.classList.contains(selector)) {
            body.classList.add(selector)
        }
    }
    function reveal() {
        if(timer) {
            window.clearTimeout(timer)
        }
        if(body.classList.contains(selector)) {
            body.classList.remove(selector)
        }
        if(about.classList.contains('expand')) {
            return
        }
        var hover = document.querySelectorAll('button:hover, input:hover')
        if(hover.length > 0) {
            return
        }
        timer = window.setTimeout(hide, 1500)
    }

    body.addEventListener('mousemove', reveal)
    body.addEventListener('keyup', function(event) {
        if(event.key === 'Tab') {
            reveal()}})
}

function setupLoader(mainstream) {
    var playpause = document.querySelector('.main .fade')
    var loading = document.querySelector('#loading')
    var selector = 'hidden'
    
    function showState(event) {
        switch(event.type) {
        case 'stalled':
        case 'loadstart':
            if(loading.classList.contains(selector)) {
                loading.classList.remove(selector)
            }
            if(!playpause.classList.contains(selector)) {
                playpause.classList.add(selector)
            }
            break
        case 'canplaythrough':
        case 'playing':
            if(!loading.classList.contains(selector)) {
                loading.classList.add(selector)
            }
            if(playpause.classList.contains(selector)) {
                playpause.classList.remove(selector)
            }
            break
        }
    }
    
    var events = ['loadstart',
                  'playing',
                  'stalled',
                  'canplaythrough']
    events.forEach(function(eventType) {
        mainstream.addEventListener(eventType, showState)})
}

function setupPlayback(body, mainstream) {
    var selector = 'hidden'
    var playing = false
    var videos = document.querySelectorAll('video')

    function togglePlayback(event) {
        event.stopPropagation() //play-button may overlap main
        videos.forEach(function(video) {
            if(!playing) {
                video.play()
            } else {
                video.pause()
            }
        })
        playing = !playing
        mainstream.dispatchEvent(new CustomEvent('sync'))
        document.querySelectorAll('#play-button use, .main .fade > use')
            .forEach(function(elem) {
                elem.classList.toggle(selector)})
    }
    function rewind() {
        doPlay()
        mainstream.currentTime = 0
        mainstream.dispatchEvent(new CustomEvent('sync'))
    }
    
    document.querySelectorAll('.main, #play-button')
        .forEach(function(button) {
            button.addEventListener('click', togglePlayback)})
    body.addEventListener('keyup', function(event) {
        if(event.keyCode == 32) {
            togglePlayback(event)}})
    mainstream.addEventListener('ended', rewind)
}

function setupPlaylist(body, playlistfile) {
    var read = new XMLHttpRequest()
    read.addEventListener('load', function() {
        doSetup(JSON.parse(read.responseText))})
    read.open('GET', playlistfile)
    read.send()

    function doSetup(playlist) {
        var template = document.getElementById('listitem-template')
        var parent = document.querySelector('#playlist')
        function togglePlaylist(event) {
            document.querySelector('#about').classList.toggle('expand')
            document.querySelectorAll('#playlist-button > svg > use, h1, h2')
                .forEach(function(icon) {
                    icon.classList.toggle('hidden')})
        }
        function switchPresentation(event) {
            var myid = document.querySelector('body').dataset.id
            var myitem = document.querySelector(`li[data-id="${myid}"]`)
            var sibling = ''
            if(event.currentTarget.id == 'previous') {
                sibling = myitem.previousElementSibling
            } else {
                sibling = myitem.nextElementSibling
            }
            window.location.href = sibling.querySelector('a').href
        }
        document.querySelector('#playlist-button')
            .addEventListener('click', togglePlaylist)
        document.querySelectorAll('#previous, #next')
            .forEach(function(button) {
                button.addEventListener('click', switchPresentation)})

        document.querySelector('#playlist-title')
            .textContent = playlist.title
        playlist.items.forEach(function(item) {
            var node = template.content.cloneNode(true)
            var li = node.querySelector('li')
            li.dataset.id = item.id
            if(li.dataset.id === body.dataset.id) {
                li.classList.add('current')
            }
            node.querySelector('img').src = item.thumb
            node.querySelector('a').href = item.link
            node.querySelector('span').textContent = item.title
            parent.appendChild(node)
        })

        document.querySelectorAll('.playlist')
            .forEach(function(button) {
                button.classList.toggle('hidden')})
    }
}

function setupProgress(body, mainstream) {
    var backdrop = document.querySelector('#progress-container')
    var pb = document.querySelector('#progress')
    var dragging = false

    var elapsed = document.querySelector('#elapsed')
    var duration = document.querySelector('#duration')
    var popup = document.querySelector('#progress-popup')

    printTime(mainstream.duration, duration)
    printTime(0, elapsed)

    function printTime(time, elem) {
        var hours = (Math.floor(time / 3600) + '').padStart(2, '0')
        var minutes = (Math.floor((time % 3600) / 60) + '').padStart(2, '0')
        var seconds = (Math.round(time % 60) + '').padStart(2, '0')
        if(mainstream.duration > 3600) {
            elem.textContent = hours +':'+ minutes +':'+ seconds
        } else {
            elem.textContent = minutes +':'+ seconds
        }
    }
    function startDrag(event) {
        dragging = true
    }
    function stopDrag(event) {
        dragging = false
    }
    function update(event) {
        if(dragging) {
            updateProgress(event.offsetX)
        }
    }
    function set(event) {
        var pos = event.offsetX
        updateProgress(pos)
        var newtime = pos / backdrop.clientWidth * mainstream.duration
        mainstream.currentTime = newtime
        mainstream.dispatchEvent(new CustomEvent('sync'))
    }
    function showPlayback(event) {
        var barSize =
            mainstream.currentTime / mainstream.duration * backdrop.clientWidth
        updateProgress(barSize)
    }
    function updateProgress(width) {
        if(width > backdrop.clientWidth) {
            width = backdrop.clientWidth
        }
        pb.style.width = width + 'px'
        var time = width / backdrop.clientWidth * mainstream.duration
        printTime(time, popup)
    }

    backdrop.addEventListener('mousedown', startDrag)
    backdrop.addEventListener('click', set)
    body.addEventListener('mousemove', update)
    body.addEventListener('mouseup', stopDrag)
    mainstream.addEventListener('timeupdate', showPlayback)
    window.setInterval(function() {
        printTime(mainstream.currentTime, elapsed)
    }, 1000)
}

function setupSpeed() {
    var videos = document.querySelectorAll('video')
    var current = document.querySelector('#speed-current')
    
    function setSpeed(event) {
        var speed = event.currentTarget.textContent
        if(event.currentTarget.id == 'speed-current') {
            return
        }
        current.textContent = speed
        videos.forEach(function(video) {
            video.playbackRate = speed})
    }

    document.querySelectorAll('#speed-select button')
        .forEach(function(button) {
            button.addEventListener('click', setSpeed)})
}

function setupSubs(subs, mainstream) {
    var subtrack = document.createElement('track')
    subtrack.kind = 'subtitles'
    subtrack.src = subs
    mainstream.appendChild(subtrack)

    var icons = document.querySelectorAll('#subtitles-button > svg > use')
    
    function toggleSubs(event) {
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
        var track = mainstream.textTracks[0]
        console.log(track)
        if(track.mode == 'disabled') {
            track.mode = 'showing'
        } else {
            track.mode = 'disabled'
        }
    }
    document.querySelector('#subtitles-button')
        .addEventListener('click', toggleSubs)
}

function setupSwitching(mainstream) {
    var main = mainstream.parentNode
    var others = document.querySelectorAll('.secondary')

    function switchStreams(event) {
        var target = event.currentTarget
        var stream = target.querySelector('video')
        var other = main.querySelector('video')
        main.replaceChild(stream, other)
        target.insertBefore(other, target.firstElementChild)
    }

    others.forEach(function(div) {
        div.addEventListener('click', switchStreams)
        div.addEventListener('keyup', function(event) {
            if(!event.isComposing && event.key === 'Enter') {
                switchStreams(event)}})
    })
}

function setupSync(mainstream) {
    var others = document.querySelectorAll('.secondary > video')
    function sync(event) {
        others.forEach(function(stream) {
            stream.currentTime = mainstream.currentTime})
    }
    
    mainstream.addEventListener('sync', sync)
}

function setupVolume(soundstream) {
    var icons = document.querySelectorAll('#volume-button > svg > use')
    var volume = document.querySelector('#volume')
    var muted = false
    var mutedVol = 0

    // There may be a cached setting to apply
    soundstream.volume = volume.value
    
    function toggleVolume(event) {
        if(!muted) {
            mutedVol = volume.value
            volume.value = 0
            soundstream.volume = 0
            muted = true
        } else {
            if(mutedVol < 0.1) {
                mutedVol = 0.1
            }
            volume.value = mutedVol
            soundstream.volume = mutedVol
            muted = false;
        }
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
    }
    function slideVolume(event) {
        soundstream.volume = event.currentTarget.value
    }
    
    document.querySelector('#volume-button')
        .addEventListener('click', toggleVolume)
    
    document.querySelector('#volume')
        .addEventListener('input', slideVolume)
}

function teardownLoader(timer) {
    window.clearInterval(timer)
    document.querySelector('#overlay .spinner').textContent = 'Done!'
    var overlay = document.querySelector('#overlay')
    overlay.classList.add('invisible')
}
