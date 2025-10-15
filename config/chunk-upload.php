<?php
/**
 * @see https://github.com/pionl/laravel-chunk-upload
 */

use Illuminate\Support\Str;

// Define the base configuration directory
$configDir = base_path() . '/systemconfig/';

// Determine the config file to use
$file = $configDir . 'play.ini';
if (!file_exists($file)) {
    $file = $configDir . 'play.ini.example';
    if (!file_exists($file)) {
        throw new Exception('Configuration file not found in ' . $configDir);
    }
}

// Parse the configuration file and handle potential parsing errors
$system_config = parse_ini_file($file, true);
if ($system_config === false) {
    throw new Exception('Error parsing configuration file: ' . $file);
}

return [
    /*
     * The storage config
     */
    'storage' => [
        /*
         * Returns the folder name of the chunks. The location is in storage/app/{folder_name}
         */
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
                'session' => true, // should the chunk name use the session id? The uploader must send cookie!,
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
