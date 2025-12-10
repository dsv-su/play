<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CatturaRecorders extends Component
{
    /**
     * @var array<int, array{recorder:string, status:string, url:string}>
     */
    public array $cattura_recorders = [];

    public function mount(): void
    {
        $path = base_path('systemconfig/play.ini');

        if (! File::exists($path)) {
            abort(503, 'System configuration file is missing.');
        }

        $ini = parse_ini_file($path, true, INI_SCANNER_TYPED);

        if ($ini === false || !isset($ini['recorders']) || !is_array($ini['recorders'])) {
            abort(503, 'Invalid or missing [recorders] section in play.ini.');
        }

        foreach ($ini['recorders'] as $recorder => $baseUrl) {
            $this->cattura_recorders[] = [
                'recorder' => (string) $recorder,
                'status'   => 'CHECKING',
                'url'      => (string) $baseUrl,
            ];
        }

        if ($this->cattura_recorders === []) {
            abort(503, 'No valid recorders configured.');
        }

        $this->refreshStatuses();
    }

    /**
     * GET /api/1/status and transform into a readable status string.
     */
    private function fetchRecorderStatus(string $baseUrl): array
    {
        try {
            $response = Http::timeout(5)->acceptJson()
                ->get(rtrim($baseUrl, '/') . '/api/1/status', ['since' => '']);

            if ($response->failed()) {
                Log::warning('Recorder unreachable', [
                    'url' => $baseUrl,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [
                    'state'   => 'UNREACHABLE',
                    'details' => [
                        'internet' => false,
                        'free_pct' => null,
                        'unit'     => '',
                    ],
                    'summary' => 'UNREACHABLE',
                ];
            }

            $data = $response->json() ?: [];

            $state = strtoupper(data_get($data, 'capture.state', 'UNKNOWN'));
            $internetUp = (bool) data_get($data, 'network.internet.connected', false);
            $total = (int) data_get($data, 'storage.total', 0);
            $free  = (int) data_get($data, 'storage.free', 0);
            $freePct = $total > 0 ? round(($free / $total) * 100) : null;
            $unit = (string) data_get($data, 'info.unitName', '');

            $summary = implode(' · ', array_filter([
                $state,
                $internetUp ? 'internet:UP' : 'internet:DOWN',
                $freePct !== null ? "free:{$freePct}%" : null,
                $unit !== '' ? "unit:{$unit}" : null,
            ]));

            return [
                'state'   => $state,
                'details' => [
                    'internet' => $internetUp ?? false,
                    'free_pct' => $freePct ?? null,
                    'unit'     => $unit ?? '',
                ],
                'summary' => $summary,
            ];
        } catch (\Throwable $e) {
            Log::error('Recorder fetch exception', [
                'url'       => $baseUrl,
                'exception' => $e->getMessage(),
            ]);
            return [
                'state'   => 'ERROR',
                'details' => [
                    'internet' => false,
                    'free_pct' => null,
                    'unit'     => '',
                ],
                'summary' => 'ERROR',
            ];
        }
    }

    public function refreshStatuses(): void
    {
        foreach ($this->cattura_recorders as $i => $rec) {
            $result = $this->fetchRecorderStatus($rec['url']);
            // store both raw state and a human summary
            $this->cattura_recorders[$i]['status']  = $result['state'];   // e.g. IDLE / RECORDING
            $this->cattura_recorders[$i]['summary'] = $result['summary']; // pretty line
            $this->cattura_recorders[$i]['details'] = $result['details']; // optional extras
        }
    }

    public function spaceClass(float|int $freeSpace): string
    {
        if ($freeSpace < 20) {
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'; // critical
        } elseif ($freeSpace < 40) {
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'; // warning
        } else {
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'; // healthy
        }
    }


    public function badgeClass(string $state): string
    {
        return match (strtoupper($state)) {
            'RECORDING',
            'CAPTURING'    => 'bg-blue-600 text-white',
            'IDLE', 'READY'=> 'bg-green-100 text-green-800',
            'UNREACHABLE',
            'ERROR'        => 'bg-red-100 text-red-800',
            default        => 'bg-gray-100 text-gray-800',
        };
    }


    public function render(): View
    {
        return view('livewire.admin.cattura-recorders', [
            'recorders' => $this->cattura_recorders,
        ]);
    }
}


