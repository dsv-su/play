<?php

declare(strict_types=1);

namespace App\Services\Notify;

use App\Models\ManualPresentation;
use App\Models\Video;
use App\Models\VideoPermission;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

final class PlayStoreNotify
{

    public const TYPE_DEFAULT   = 'default';
    public const TYPE_EDIT      = 'edit';
    public const TYPE_BULK      = 'bulk';

    private ManualPresentation|Video $presentation;
    private ClientInterface $http;
    private bool $renderThumb;

    public function __construct(
        ManualPresentation|Video $presentation,
        ?ClientInterface $http = null,
        bool $renderThumb = false
    )

    {
        $this->presentation = $presentation;
        $this->http         = $http ?? new Client();
        $this->renderThumb  = $renderThumb;
    }

    /**
     * Build and optionally send the notification.
     *
     * @return array|string|RedirectResponse|bool  Array (payload) on dryRun, redirect/bool on send
     */
    public function sendSuccess(string $type, bool $dryRun = false): array|string|RedirectResponse|bool
    {
        $this->assertValidType($type);

        // 1) Build payload without mutating the Eloquent model
        $payload = $this->buildPayload($type);

        if ($dryRun) {
            // JSON for debugging
            return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // 2) Send
        $uri = $this->uri();

        try {
            $response = $this->http->request('POST', $uri, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'body'    => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'timeout' => 20,
            ]);

            $status  = $response->getStatusCode();
            $bodyStr = (string) $response->getBody();

            if ($status < 200 || $status >= 300 || $bodyStr === '') {
                return $this->handleSendFailure($type, 'Empty or non-2xx response.');
            }

            // Persist job id and statuses
            $jobId = trim($bodyStr);

            //Re-load ManualPresentation
            $model = ManualPresentation::find($this->presentation->id);

            if ($model) {
                // For "edit" we only set jobid + status=sent (matches original intent)
                $model->jobid  = $jobId;
                $model->status = 'sent';
                $model->save();
            }

            // Update VideoPermission
            $videoPermission = $type === self::TYPE_EDIT
                ? VideoPermission::where('video_id', $this->presentation->pkg_id)->first()
                : VideoPermission::where('notification_id', $this->presentation->id)->first();

            if ($videoPermission) {
                $videoPermission->jobid = $jobId;
                $videoPermission->save();
            }

            if ($type === self::TYPE_EDIT) {
                // Original code returns true for edit
                return true;
            }

            $message = App::isLocale('swe') ? 'Bearbetar presentationen' : 'Processing the presentation';
            return redirect('/')->with(['message' => $message]);

        } catch (GuzzleException $e) {
            // Mark failed + log body if available
            Log::error('PlayStoreNotify send failed', [
                'message' => $e->getMessage(),
            ]);

            return $this->handleSendFailure($type, $e->getMessage());
        }
    }

    /**
     * Send a DELETE request to remove the presentation in the external service.
     *
     * @param  bool  $dryRun  If true, just return the JSON payload instead of sending.
     * @return bool|string    true on successful delete, false on failure, JSON string on dryRun
     */
    public function sendDelete(bool $dryRun = false): bool|string
    {
        // Build URI for this presentation
        $uri = rtrim($this->uri(), '/') . '/' . $this->presentation->id;

        // Auth payload
        $payload = [
            'auth' => $this->storeauth(),
        ];

        if ($dryRun) {
            // For debugging the outgoing request
            return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        try {
            $response = $this->http->request('DELETE', $uri, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'body'    => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'timeout' => 20,
            ]);
        } catch (RequestException $e) {
            // If the server responded with an error, log body if present
            $body = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;

            Log::error('PlayStoreNotify delete failed (request exception)', [
                'message' => $e->getMessage(),
                'body'    => $body,
            ]);

            return false;
        } catch (GuzzleException $e) {
            Log::error('PlayStoreNotify delete failed (guzzle exception)', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }

        $status  = $response->getStatusCode();
        $bodyStr = (string) $response->getBody();

        if ($status < 200 || $status >= 300) {
            Log::warning('PlayStoreNotify delete non-2xx response', [
                'status' => $status,
                'body'   => $bodyStr,
            ]);
            return false;
        }

        // $data = $bodyStr !== '' ? json_decode($bodyStr, true) : null;

        return true;
    }

    /**
     * Outgoing payload array without mutating the model.
     */
    private function buildPayload(string $type): array
    {
        $p = $this->presentation->toArray();

        //Remove fields that are noise
        unset(
            $p['id'], $p['title_en'], $p['status'], $p['type'], $p['jobid'], $p['duration'],
            $p['sublanguage'], $p['user'], $p['user_email'], $p['local'], $p['category_id'],
            $p['visibility'], $p['unlisted'], $p['files'], $p['permission'],
            $p['entitlement'], $p['daisy_courses'], $p['created_at'], $p['updated_at']
        );

        // Title mapping
        $titleSv = $this->presentation->title ?? '';
        $titleEn = $this->presentation->title_en ?? $titleSv;

        $p['title'] = ['sv' => $titleSv, 'en' => $titleEn];

        //Conditional removals
        if (empty($this->presentation->pkg_id))    unset($p['pkg_id']);
        if (empty($this->presentation->upload_dir)) unset($p['upload_dir']);

        //Edit
        if (empty($this->presentation->sources ) && $type == 'edit')    unset($p['sources']);
        if ($type === self::TYPE_EDIT && $this->renderThumb) {
            $p['thumb'] = '';
        } elseif (empty($this->presentation->thumb) && $type === self::TYPE_EDIT) {
            unset($p['thumb']);
        }

        // Normalize arrays
        $p['presenters'] = $this->normalizeArray($p['presenters'] ?? null);
        $p['courses']    = $this->normalizeArray($p['courses'] ?? null);
        $p['tags']       = $this->normalizeArray($p['tags'] ?? null);

        // Sources should always be a dict (object)
        if (isset($p['sources'])) {
            $p['sources'] = (object) $p['sources'];
        }

        //Normalize string
        $p['description'] = $this->normalizeString($p['description'] ?? '');

        //Normalize int
        $p['created']    = $this->normalizeInt($p['created'] ?? null);

        //Bulk
        if ($type == 'bulk')    unset($p['title']);
        if ($type == 'bulk')    unset($p['title_en']);
        if ($type == 'bulk')    unset($p['sources']);
        if ($type == 'bulk')    unset($p['description']);
        if (empty($this->presentation->thumb) && $type == 'bulk')    unset($p['thumb']);
        if (in_array('origin', Arr::wrap($this->presentation->courses), true) && $type === 'bulk') {
            unset($p['courses']);
        }
        if (in_array('origin', Arr::wrap($this->presentation->presenters), true) && $type === 'bulk') {
            unset($p['presenters']);
        }
        if (in_array('origin', Arr::wrap($this->presentation->tags), true) && $type === 'bulk') {
            unset($p['tags']);
        }

        //Subtitles
        $hasSubs = !empty($this->presentation->subtitles);
        if (!$hasSubs) {
            unset($p['subtitles']);
        }
        if (empty($this->presentation->autogenerate_subtitles)) {
            //Hide flag and json
            unset($p['autogenerate_subtitles'], $p['generate_subtitles']);
        } else {
            //Hide flag
            unset($p['autogenerate_subtitles']);
        }

        return $p;
        // Remove nulls to keep payload clean
        //return $this->removeNulls($p);
    }

    private function normalizeArray(mixed $value): array
    {
        return is_array($value) ? array_values($value) : [];
    }

    private function normalizeString(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    private function normalizeInt(mixed $value): int
    {
        return is_numeric($value) ? (int) $value : 0;
    }


    private function removeNulls(array $arr): array
    {
        return array_filter($arr, static function ($v) {
            if (is_array($v)) {
                return count($v) > 0;
            }
            return $v !== null;
        });
    }

    private function handleSendFailure(string $type, string $reason): RedirectResponse
    {
        // Fail ManualPresentation
        $model = ManualPresentation::find($this->presentation->id);
        if ($model) {
            $model->status = 'failed';
            $model->save();
        }

        Log::error('PlayStoreNotify: send failed', ['reason' => $reason]);

        $message = App::isLocale('swe')
            ? 'Något gick fel med uppladdningen'
            : 'Something went wrong with the upload';

        return redirect('/')->with(['message' => $message]);
    }

    private function assertValidType(string $type): void
    {
        if (!in_array($type, [self::TYPE_DEFAULT, self::TYPE_EDIT, self::TYPE_BULK], true)) {
            throw new \InvalidArgumentException("Invalid type '{$type}'.");
        }
    }

    private function base_uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['list_uri'];
    }

    private function uri()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['notify_uri'];
    }


    private function storeauth()
    {
        $this->file = base_path() . '/systemconfig/play.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/play.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['store']['notify_auth'];
    }
}
