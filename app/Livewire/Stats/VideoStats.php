<?php

namespace App\Livewire\Stats;

use App\Models\Video;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Livewire\Attributes\Computed;
use Livewire\Component;

class VideoStats extends Component
{
    public ?Video $video = null;

    public array $datasets = [];

    public function mount()
    {
        $this->getData();
    }

    #[Computed]
    public function chart()
    {
        return Chartjs::build()
            ->name('PresentationChart')
            ->livewire()
            ->model('datasets') // binds to $this->datasets
            ->type('line');
    }

    public function getData(): void
    {
        $video = Video::find('12fa812d-19dc-465b-a98a-0f9bccc81c73');

        // guard against nulls so you don’t get another error
        if (! $video || ! $video->videoStats) {
            $this->datasets = [
                'datasets' => [],
                'labels'   => [],
            ];

            return;
        }

        $data   = [$video->videoStats->playback];
        $labels = ['Playback'];

        $this->datasets = [
            'datasets' => [
                [
                    'label'           => 'Presenattion clicks',
                    'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                    'borderColor'     => 'rgba(38, 185, 154, 0.7)',
                    'data'            => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    public function render()
    {
        return view('livewire.stats.video-stats');
    }
}
