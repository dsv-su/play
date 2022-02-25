document.addEventListener('DOMContentLoaded', init)

function init() {
    var cookies = getCookies()
    var args = getArgs()
    var mainstream = document.querySelector('.main > video')
    setupLoader(mainstream)

    if(typeof localPresentation !== "undefined") {
        doSetup(localPresentation, null)
    } else {
        if(args.hasMore) {
            document.getElementById('more-indicator').classList.toggle('hidden')
        }
        var read = new XMLHttpRequest()
        read.addEventListener('load', function() {
            var data = null
            try {
                data = JSON.parse(read.responseText)
            } catch(e) {
                console.log("Unable to parse as JSON:")
                console.log(read.responseText)
                throw new Error("Could not get presentation data.")
            }
            doSetup(data, args.getList())
        })
        read.open('GET', args.getPres())
        read.send()
    }
    function doSetup(presentation, playlist) {
        var body = document.querySelector('body')
        var mainstream = document.querySelector('.main > video')

        // A bit too magic with all the [0] but what can you do...
        var defaultres = Object.keys(presentation.sources[0].video)[0]

        if('resolution' in cookies) {
            defaultres = cookies.resolution
        }

        if('language' in cookies) {
            var lang = cookies['language']
            if (lang != 'se') {
                document.querySelector('html').lang = lang
                var dataname = 'title_' + lang
                document.querySelectorAll('[data-' + dataname + ']').forEach(
                    function(tag) {
                        tag.title = tag.dataset[dataname]})
                var altname = 'title_alt_' + lang
                document.querySelectorAll('[data-' + altname + ']').forEach(
                    function(tag) {
                        tag.dataset['title_alt'] = tag.dataset[altname]})
            }
        }

        body.dataset.id = presentation.id

        if(playlist) {
            setupPlaylist(body, playlist)
        }
        
        loadStreams(presentation, mainstream, defaultres)

        function awaitLoad(callback) {
            var loaded = 0
            var streams = document.querySelectorAll('video')
            streams.forEach(function(stream) {
                stream.addEventListener('loadedmetadata', function(event) {
                    loaded += 1
                    if(loaded === streams.length) {
                        callback()}})})
            
            setupHiding(body, mainstream)
            setupAbout(presentation.title)
            setupBlur()
            setupSpeed()
            setupFullscreen()
            setupCopying(mainstream)
            setupVolume(mainstream, cookies.volume, cookies.mute)
            setupResSwitching(presentation.sources, defaultres)
            setupSwitching(mainstream)
            setupSync(mainstream)
            setupPlayback(body, mainstream)
            setupSubs(presentation.subtitles,
                      cookies.subtitles,
                      presentation.token)
        }
        awaitLoad(function() {
            setupBuffer(mainstream)
            setupProgress(body, mainstream, args.timecode)
        })
    }
}

function getArgs() {
    var get = window.location.search.substring(1)
    var out = {'presentation': null,
               'playlist': null,
               'hasMore': null,
               'timecode': 0}
    var shortnames = {'presentation': 'p',
                      'playlist': 'l',
                      'hasMore': 'm',
                      'timecode': 't',
                      'debug': 'debug'}
    get.split('&').forEach(function(arg) {
        [name, value] = arg.split('=')
        value = decodeURIComponent(value)
        switch(name) {
        case 'presentation':
        case 'play':
        case 'show':
        case 'p':
        case 's':
            out.presentation = value
            break
        case 'playlist':
        case 'list':
        case 'l':
            out.playlist = value
            break
        case 'more':
        case 'm':
            out.hasMore = true
            break
        case 'timestamp':
        case 'timecode':
        case 'time':
        case 't':
            out.timecode = value
            break;
        case 'debug':
            out.debug = true
            break
        }
    })
    out.toString = function() {
        var result = []
        for(key of Object.keys(shortnames)) {
            if(this[key]) {
                result.push(shortnames[key] + '=' + this[key])
            }
        }
        return result.join('&')
    }
    out.getPres = function() {
        if(this.debug) {
            return this.presentation
        }
        return '/presentation/' + this.presentation
    }
    out.getList = function() {
        if(this.debug) {
            return this.playlist
        }
        return '/playlist/' + this.playlist
    }
    return out
}

function getCookies() {
    var out = new Object()
    var cookies = document.cookie.split('; ')
    cookies.forEach(function(cookie) {
        var temp = cookie.split('=')
        var name = temp[0]
        var value = temp.slice(1).join('=')
        out[name] = value
    })
    return out
}

function setCookie(name, value) {
    var cookie = name + "=" + value
    cookie += ";samesite=strict"
    document.cookie = cookie
}

function delCookie(name) {
    var cookie = name + '='
    cookie += ';samesite=strict;expires=Thu, 01 Jan 1970 00:00:01 GMT'
    document.cookie = cookie
}

function swapText(element) {
    var oldtext = element.title
    element.title = element.dataset['title_alt']
    element.dataset['title_alt'] = oldtext
}

function loadStreams(presentation, mainstream, defaultres) {
    var streamlist = presentation.sources
    var token = presentation.token
    var mainparent = mainstream.parentNode
    var template = document.getElementById('stream-template')

    var main = streamlist[0]
    
    if(typeof main.video === "string") {
        mainstream.src = main.video +"?token="+ token
    } else {
        Object.keys(main.video).forEach(function(res) {
            var tokenized = main.video[res] +"?token="+ token
            mainstream.dataset[res] = tokenized
        })
        mainstream.src = mainstream.dataset[defaultres]
    }
    mainstream.muted = !main.playAudio
    mainstream.poster = main.poster
    mainstream.load()
    for (var i = 1; i < streamlist.length; i++) {
        var newstream = template.content.cloneNode(true)
        var video = newstream.querySelector('video')
        if(typeof streamlist[i].video === "string") {
            video.src = streamlist[i].video +"?token="+ token
        } else {
            Object.keys(streamlist[i].video).forEach(function(res) {
                var tokenized = streamlist[i].video[res] +"?token="+ token
                video.dataset[res] = tokenized
            })
            video.src = video.dataset[defaultres]
        }
        video.muted = !streamlist[i].playAudio
        video.poster = streamlist[i].poster
        video.load()
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

function setupCopying(mainstream) {
    var copyButton = document.querySelector('#timelink-button')
    if(copyButton) { // might not exist in case of local playback
        copyButton.addEventListener('click', function(event) {
            var url = window.location.href.split('?')[0]
            var args = getArgs()
            args.timecode = mainstream.currentTime
            navigator.clipboard.writeText(url + '?' + args)
        })
    }
}

function setupFullscreen() {
    var body = document.querySelector('body')
    var icons = document.querySelectorAll('#fullscreen-button > svg > use')
    var button = document.querySelector('#fullscreen-button')
    
    function toggleFullscreen(event) {
        if(document.fullscreenElement) {
            document.exitFullscreen()
        } else {
            body.requestFullscreen()
        }
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
        swapText(button)
    }

    button.addEventListener('click', toggleFullscreen)
}

function setupHiding(body, mainstream) {
    const selector = 'nocursor'
    var timer = null
    var controls = document.querySelector('#controls')
    var about = document.querySelector('#about')
    
    function hide() {
        if(about.classList.contains('expand')) {
            return
        }
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
        timer = window.setTimeout(hide, 2500)
    }

    body.addEventListener('mousemove', reveal)
    body.addEventListener('mouseleave', hide)
    body.addEventListener('keyup', function(event) {
        if(event.key === 'Tab') {
            reveal()}})
    hide()
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
    var button = document.querySelector('#play-button')
    var playing = false
    var videos = document.querySelectorAll('video')

    function togglePlayback() {
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
        swapText(button)
    }
    function rewind() {
        togglePlayback()
        mainstream.currentTime = 0
        mainstream.dispatchEvent(new CustomEvent('sync'))
    }
    
    document.querySelectorAll('.main, #play-button')
        .forEach(function(button) {
            button.addEventListener('click', togglePlayback)})
    body.addEventListener('keyup', function(event) {
        if(event.keyCode == 32) { //space
            togglePlayback(event)}})
    mainstream.addEventListener('ended', rewind)
}

function setupPlaylist(body, playlistfile) {
    var read = new XMLHttpRequest()
    read.addEventListener('load', function() {
        var data = null
        try {
            data = JSON.parse(read.responseText)
        } catch(e) {
            console.log("Could not parse as JSON:")
            console.log(read.responseText)
        }
        doSetup(data)
    })
    read.open('GET', playlistfile)
    read.send()

    function doSetup(playlist) {
        var template = document.getElementById('listitem-template')
        var parent = document.querySelector('#playlist')
        var button = document.querySelector('#playlist-button')
        function togglePlaylist(event) {
            document.querySelector('#about').classList.toggle('expand')
            document.querySelectorAll('#playlist-button > svg > use, h1, h2')
                .forEach(function(icon) {
                    icon.classList.toggle('hidden')})
            swapText(button)
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
        button.addEventListener('click', togglePlaylist)
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

function setupProgress(body, mainstream, starttime) {
    var backdrop = document.querySelector('#progress-container')
    var pb = document.querySelector('#progress')
    var dragging = false

    var elapsed = document.querySelector('#elapsed')
    var duration = document.querySelector('#duration')
    var popup = document.querySelector('#progress-popup')

    printTime(mainstream.duration, duration)
    printTime(starttime, elapsed)
    setTime(starttime)

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
    function setPos(event) {
        var pos = event.offsetX
        updateProgress(pos)
        var newtime = pos / backdrop.clientWidth * mainstream.duration
        setTime(newtime)
    }
    function setTime(newtime) {
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
    backdrop.addEventListener('click', setPos)
    body.addEventListener('mousemove', update)
    body.addEventListener('mouseup', stopDrag)
    mainstream.addEventListener('timeupdate', showPlayback)
    window.setInterval(function() {
        printTime(mainstream.currentTime, elapsed)
    }, 500)
    body.addEventListener('keyup', function(event) {
        switch(event.keyCode) {
        case 37: //left
            setTime(mainstream.currentTime - 5)
            break
        case 39: //right
            setTime(mainstream.currentTime + 5)
            break
        default:
            break
        }
    })
}

function setupResSwitching(streamlist, defaultres) {
    var videos = document.querySelectorAll('video')
    var current = document.getElementById('resolution-current')
    var list = document.getElementById('resolution-list')
    var template = document.getElementById('resolution-template')
    var resolutions = Object.keys(streamlist[0].video).sort(function(a, b) {
        return b - a
    })

    current.textContent = defaultres

    function setResolution(event) {
        var resolution = event.currentTarget.textContent
        var mainstream = document.querySelector('.main > video')
        var playbutton = document.querySelector('#play-button')
        var time = mainstream.currentTime
        var paused = mainstream.paused
        if(current.textContent == resolution) {
            return
        }
        if(!paused) {
            playbutton.dispatchEvent(new Event('click'))
        }
        videos.forEach(function(video) {
            video.src = video.dataset[resolution]
            video.currentTime = time
        })
        if(!paused) {
            playbutton.dispatchEvent(new Event('click'))
        }
        current.textContent = resolution
        setCookie('resolution', resolution)
    }

    resolutions.forEach(function(resolution) {
        var newitem = template.content.cloneNode(true)
        var button = newitem.querySelector('button')
        button.textContent = resolution
        button.addEventListener('click', setResolution)
        list.appendChild(newitem)
    })
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

function setupSubs(subs, subCookie, accessToken) {
    var button = document.querySelector('#subtitles-button')
    var icons = document.querySelectorAll('#subtitles-button > svg > use')

    if(!subs) {
        button.parentNode.removeChild(button)
        return
    }
    document.querySelectorAll('video').forEach(function(stream) {
        var subtrack = document.createElement('track')
        subtrack.kind = 'subtitles'
        subtrack.src = subs + '?token=' + accessToken
        stream.appendChild(subtrack)
    })

    function toggleSubs(event) {
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
        var mainstream = document.querySelector('.main > video')
        var track = mainstream.textTracks[0]
        if(track.mode == 'disabled') {
            track.mode = 'showing'
            setCookie('subtitles', 'on')
        } else {
            track.mode = 'disabled'
            delCookie('subtitles')
        }
        swapText(button)
    }
    document.querySelector('#subtitles-button')
        .addEventListener('click', toggleSubs)

    if(subCookie == 'on') {
        toggleSubs(null)
    }
}

function setupSwitching(mainstream) {
    var main = mainstream.parentNode

    function switchStreams(event) {
        var curmain = main.querySelector('video')
        var target = event.currentTarget
        var newmain = target.querySelector('video')
        var curmode = curmain.textTracks[0].mode
        var newmode = newmain.textTracks[0].mode

        curmain.textTracks[0].mode = newmode
        newmain.textTracks[0].mode = curmode

        main.replaceChild(newmain, curmain)
        target.insertBefore(curmain, target.firstElementChild)
    }

    document.querySelectorAll('.secondary')
        .forEach(function(div) {
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

function setupVolume(soundstream, volCookie, muteCookie) {
    var icons = document.querySelectorAll('#volume-button > svg > use')
    var button = document.querySelector('#volume-button')
    var volume = document.querySelector('#volume')
    var muted = false
    var mutedVol = 0

    function toggleVolume(event) {
        if(!muted) {
            mutedVol = volume.value
            volume.value = 0
            soundstream.volume = 0
            muted = true
            setCookie('mute', 'on')
        } else {
            if(mutedVol < 0.1) {
                mutedVol = 0.1
            }
            volume.value = mutedVol
            soundstream.volume = mutedVol
            muted = false
            delCookie('mute')
        }
        icons.forEach(function(icon) {
            icon.classList.toggle('hidden')})
        swapText(button)
    }
    function slideVolume(event) {
        var newVol = event.currentTarget.value
        soundstream.volume = newVol
        setCookie('volume', newVol)
    }
    
    button.addEventListener('click', toggleVolume)
    volume.addEventListener('input', slideVolume)

    if(volCookie) {
        soundstream.volume = volCookie
        volume.value = volCookie
    }

    if(muteCookie) {
        toggleVolume(null)
    }
}

function teardownLoader(timer) {
    window.clearInterval(timer)
    document.querySelector('#overlay .spinner').textContent = 'Done!'
    var overlay = document.querySelector('#overlay')
    overlay.classList.add('invisible')
}
