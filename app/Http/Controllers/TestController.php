<?php

namespace App\Http\Controllers;

use App\Services\Daisy\DaisyHealthChecker;
use Illuminate\Support\Facades\Storage;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;
use Prism\Prism\ValueObjects\Media\Document;

class TestController extends Controller
{
    public function index()
    {
        //$this->cleanVttFile();
        $rawContent = Storage::get('public/test/cleaned.txt');
        return $rawContent;
        /*$response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-5')
            ->withSystemPrompt('You are an expert language translator.')
            ->withPrompt(
                'Translate this to german:' . $rawContent)
            ->asText();

        echo $response->text;*/
    }


    public function cleanVttFile()
    {
        // Input & output paths
        $inputPath = 'public/test/Generated.vtt';
        $outputPath = 'public/test/cleaned.txt';

        // Read file
        $content = Storage::get($inputPath);

        // Split into lines
        $lines = preg_split("/\r\n|\n|\r/", $content);

        $cleanLines = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip empty lines
            if ($line === '') {
                continue;
            }

            // Skip WEBVTT header
            if (strtoupper($line) === 'WEBVTT') {
                continue;
            }

            // Skip timestamps (WEBVTT format)
            if (preg_match('/^\d{2}:\d{2}:\d{2}\.\d{3}\s-->\s\d{2}:\d{2}:\d{2}\.\d{3}$/', $line)) {
                continue;
            }

            // Keep text lines
            $cleanLines[] = $line;
        }

        // Join text into readable paragraphs
        $cleanText = implode(' ', $cleanLines);

        // Optional: normalize spaces
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);

        // Store cleaned file
        Storage::put($outputPath, $cleanText);

        return 'File cleaned and stored successfully.';
    }


    public function server()
    {
        //dd($_SERVER);
    }

    public function health(DaisyHealthChecker $checker)
    {
        $data = $checker->call();
        return response()->json($data);
    }
}

