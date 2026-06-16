# Multiplayer - a multi-stream HTML5 video player

This player plays multiple streams in parallel with a single set of
controls. It has been tested with up to 4 streams but should in principle
be able to handle an arbitrary number for streams.

The player uses a simple json format to bundle several streams along with
some metadata. The format is exemplified in `packagedef.json`. Such a bundle
is usually referred to as a "presentation".

There is also support for playlists, which are also specified in json
format. That format is exemplified in `listdef.json`

## Online playback

When playing back presentations online, `index.html` should be called with
the following GET parameters:
 - `presentation`: The ID of a presentation package available on the same
   web server under `/presentation/<ID>`
   
   Allowed aliases for this parameter: `play`, `show`, `p` and `s`

 - `playlist` (optional): The ID of a playlist package available on the
   same web server under `/playlist/<ID>`

   Allowed aliases for this parameter are `list` and `l`

## Offline playback

The intended use for offline playback is to enable a download feature in a
video portal. When playing pack a presentation offline (using files stored
on the local machine), `dlplayer.html` should be used instead of `index.html`.

The downloaded package should contain:
 - `dlplayer.html`: This is a version of `index.html` that includes all
support files in-line to reduce the number of files for the downloading user
to deal with.

   In order for the file to point to the correct presentation data, there is a
line that looks like this: `localPresentation = %PACKAGE%`

   When preparing a download package, the preparing script should replace
`%PACKAGE%` with the json package data relating to the presentation to
be downloaded.

- A subdirectory containing the media files

  The paths in the json package data should be relative to `dlplayer.html`.

Offline playback doesn't support playlists.

## Other parameters

There are a few GET parameters that are respected but don't neatly fit
into the above:

 - `debug`: Disables automatic prefixing of presentation and playlist
   paths. Useful when testing and the `/presentation` or `/playlist`
   context paths are unavailable.

 - `more`: Displays a small down arrow in the middle of the video control
   bar. Only exists so that it will be more obvious that there is more
   content to see below the presentation when playing in the
   play platform.
