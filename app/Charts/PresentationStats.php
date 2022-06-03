<?php

declare(strict_types = 1);

namespace App\Charts;

use App\VideoStat;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class PresentationStats extends BaseChart
{
    public ?string $name = 'Presentations statistics';
    public ?string $routeName = 'my_chart';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function handler(Request $request): Chartisan
    {
        $id = $request->id;
        $video_stats = VideoStat::where('video_id', $id)->get();
        $labels = [];
        $count = [];
        array_push($labels, 'Playback', 'Downloads');
        foreach ($video_stats as $stats) {
            array_push($count, $stats->playback);
            array_push($count, $stats->download);
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Clicks', $count);
    }
}

