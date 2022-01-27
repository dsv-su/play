<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Symfony\Component\String\s;

class UpdateMultiplayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:multiplayer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This artisan command is used to pull the latest committed updates from the multiplayer repo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Update multiplayer repo
        $update_multiplayer = 'cd '.storage_path().'/app/multiplayer;git pull';
        $create_local_player = 'cd '.storage_path().'/app/multiplayer;python3 make_dlplayer.py';
        // Integrate multiplayer
        $js_files = 'cp '. storage_path(). '/app/multiplayer/player.js '.public_path().'/js/';
        $css_files = 'cp '. storage_path(). '/app/multiplayer/*.css '.public_path().'/css/player/';

        exec($update_multiplayer, $output);
        //dd($output[0]);
        if($output[0] == 'Already up to date.') {
            $this->comment( 'Multiplayer is '. implode( PHP_EOL, $output ) );
        } else {
            exec($create_local_player);
            exec($js_files);
            exec($css_files);

            //Read multiplayer DOM
            $multiplayer = \Illuminate\Support\Facades\Storage::get('multiplayer/index.html');

            $favicon = '"./css/player/favicon.ico"';
            $style = '"./css/player/style.css?a"';
            $player = '"./js/player.js"';

            $head = '
                <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <link rel="shortcut icon" href="{{ asset('.$favicon.') }}">
                <link rel="stylesheet" href="{{ asset('.$style.')}}">
                <title></title>
                <script src="{{asset('.$player.')}}" defer></script>
                </head>
                ';

            //Finds <head>
            $regex = '(<head>([\s\S]*)<\/head>)';
            preg_match_all($regex, $multiplayer, $matches, PREG_SET_ORDER, 0);

            //Integrate
            $replaced = Str::replace($matches[0][0], $head, $multiplayer);

            Storage::put('multiplayer/index.blade.php', $replaced);

            $blade = 'mv '.storage_path(). '/app/multiplayer/index.blade.php ';
            $base = base_path(). '/resources/views/player/index.blade.php';
            // Print output
            exec($blade.$base);

            $this->comment( 'Multiplayer successfully updated' );

        }
        return 0;
    }
}
