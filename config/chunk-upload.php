<?php

$file = base_path().'/systemconfig/play.ini';
if (!file_exists($file)) {
    $file = base_path().'/systemconfig/play.ini.example';
}
$system_config = parse_ini_file($file, true);
/**
 * @see https://github.com/pionl/laravel-chunk-upload
 */

return [
    /*
     * The storage config
     */
    'storage' => [
        /*
         * Returns the folder name of the chunks.
         */
        //'chunks' => 'chunks',
        //'disk' => 'local',
        'chunks' => $system_config['nfs']['chunks'],
        'disk' => 'play-store',
    ],
    'clear' => [
        /*
         * How old chunks we should delete
         */
        'timestamp' => '-3 HOURS',
        'schedule' => [
            'enabled' => true,
            'cron' => '25 * * * *', // run every hour on the 25th minute
        ],
    ],
    'chunk' => [
        // setup for the chunk naming setup to ensure same name upload at same time
        'name' => [
            'use' => [
                'session' => false, // should the chunk name use the session id? The uploader must send cookie!,
                'browser' => false, // instead of session we can use the ip and browser?
            ],
        ],
    ],
    'handlers' => [
        // A list of handlers/providers that will be appended to existing list of handlers
        'custom' => [],
        // Overrides the list of handlers - use only what you really want
        'override' => [
            // \Pion\Laravel\ChunkUpload\Handler\DropZoneUploadHandler::class
        ],
    ],
];
