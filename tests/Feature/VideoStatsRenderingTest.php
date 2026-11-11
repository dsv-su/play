<?php

namespace Tests\Feature;

use App\Livewire\Stats\VideoStats;
use App\Models\Video;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\Concerns\InteractsWithPresentationLibrary;
use Tests\TestCase;

class VideoStatsRenderingTest extends TestCase
{
    use InteractsWithPresentationLibrary {
        setUp as protected setUpLibrary;
    }

    protected function setUp(): void
    {
        $this->setUpLibrary();
        Schema::create('video_stats', function (Blueprint $table) {
            $table->string('video_id');
            $table->integer('playback')->default(0);
            $table->integer('download')->default(0);
        });
    }

    public function test_modal_renders_and_rebuilds_chart_for_selected_period(): void
    {
        $component = Livewire::test(RenderableVideoStats::class, ['video' => Video::findOrFail('45')])
            ->assertDontSee('role="dialog"', false)
            ->dispatch('open-chart-modal', videoId: 'other')
            ->assertSet('showModal', false)
            ->dispatch('open-chart-modal', videoId: '45')
            ->assertSet('showModal', true)
            ->assertSeeHtml('role="dialog"')
            ->assertSeeHtml('x-teleport="body"')
            ->assertSee('Close metrics dialog')
            ->assertSet('datasets.datasets.0.data', [7])
            ->call('setPeriod', 'month')
            ->assertSet('period', 'month')
            ->assertSet('datasets.datasets.0.data', [30]);

        $this->assertStringContainsString('metrics-chart-'.$component->instance()->getId().'-month', $component->html());
        $component->call('setPeriod', 'invalid')->assertSet('period', 'month')
            ->call('closeModal')->assertSet('showModal', false);
    }

    public function test_stats_controls_have_swedish_labels(): void
    {
        app()->setLocale('sv');
        Livewire::test(RenderableVideoStats::class, ['video' => Video::findOrFail('45')])
            ->dispatch('open-chart-modal', videoId: '45')
            ->assertSee('Vecka')->assertSee('Månad')->assertSee('Stäng statistikdialogen')
            ->assertSet('datasets.datasets.0.label', 'Antal presentationsvisningar');
    }

    public function test_chart_shows_a_clear_message_when_no_views_are_recorded(): void
    {
        Livewire::test(EmptyVideoStats::class, ['video' => Video::findOrFail('45')])
            ->dispatch('open-chart-modal', videoId: '45')
            ->assertSee('No views recorded for this period.')
            ->assertDontSeeHtml('<canvas');
    }
}

class RenderableVideoStats extends VideoStats
{
    protected function calcWeek()
    {
        return collect([(object) ['year' => 2026, 'month' => 11, 'day' => 11, 'value' => 7]]);
    }

    protected function calcMonth()
    {
        return collect([(object) ['year' => 2026, 'month' => 11, 'day' => 11, 'value' => 30]]);
    }

    protected function totalCount()
    {
        $this->sum_week = 7;
        $this->sum_month = 30;
        $this->sum_year = 90;
    }
}

class EmptyVideoStats extends RenderableVideoStats
{
    protected function calcWeek()
    {
        return collect();
    }
}
