<?php

namespace App\Livewire\Stats;

use App\Models\Video;
use Carbon\Carbon;
use DirectoryTree\Metrics\Metric;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class VideoStats extends Component
{
    public ?Video $video = null;
    public array $datasets = [];
    public array $labels = [];
    public array $data = [];
    public bool $showModal = false;
    public $sum_year, $sum_month, $sum_week;

    // 'week' by default
    public string $period = 'week';

    #[Computed]
    public function chart()
    {
        return Chartjs::build()
            ->name('PresentationChart')
            ->livewire()
            ->model('datasets')
            ->type('line');
    }

    #[On('open-chart-modal')]
    public function openModal(string $videoId): void
    {
        // Only open for the matching video component
        if ((string) $this->video->id !== (string) $videoId) {
            return;
        }

        $this->period = 'week';  // default range
        $this->getData();        // load datasets for week
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function setPeriod(string $period): void
    {
        // guard against invalid values if you want
        if (!in_array($period, ['week', 'month'], true)) {
            return;
        }

        $this->period = $period;
        $this->getData(); // recalc + rerender
    }

    protected function calcWeek()
    {
        return Metric::thisWeek()->where('vid', $this->video->id)->get();
    }

    protected function calcMonth()
    {
        return Metric::thisMonth()->where('vid', $this->video->id)->get();
    }
    protected function buildLabelsAndData($metrics): void
    {
        $this->labels = [];
        $this->data = [];

        foreach ($metrics as $metric) {
            $date = Carbon::create($metric->year, $metric->month, $metric->day);
            $this->labels[] = $date->format('d M');
            $this->data[]   = $metric->value ?? 0;
        }
    }


    protected function totalCount()
    {
        $this->sum_year = Metric::thisYear()->where('vid', $this->video->id)->sum('value');
        $this->sum_month = Metric::thisMonth()->where('vid', $this->video->id)->sum('value');
        $this->sum_week = Metric::thisWeek()->where('vid', $this->video->id)->sum('value');
    }

    public function getData(): void
    {
        // Choose metrics based on current period
        $metrics = $this->period === 'month'
            ? $this->calcMonth()
            : $this->calcWeek();

        $this->buildLabelsAndData($metrics);
        // Choose labels and data based on current period
        /*$this->period === 'month'
            ? $this->labelMonth($metrics)
            : $this->labelWeek($metrics);*/

        $labels = $this->labels;
        $data   = $this->data;

            // Livewire-bound data (matches ->model('datasets'))
        $this->datasets = [
            'datasets' => [
                [
                    'label'           => 'Number of Presentation clicks',
                    'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                    'borderColor'     => 'rgba(38, 185, 154, 0.7)',
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data'            => $data,
                ],
            ],
            'labels' => $labels,
        ];

        //Calc total metrics
        $this->totalCount();
    }

    public function render()
    {
        return view('livewire.stats.video-stats');
    }
}

