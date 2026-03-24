<?php

namespace App\Http\Controllers;

use App\Services\Daisy\DaisyHealthChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;
use Prism\Prism\ValueObjects\Media\Document;

class TestController extends Controller
{
    protected $video;

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

    /**
     * Renders a small "AI chat prompt" textbox + button.
     *
     */
    public function aiPrompt()
    {
        return response()->view('ai.prompt');
    }

    public function aiPromptSubmit(Request $request)
    {
        $data = $request->validate([
            'prompt' => ['required', 'string', 'max:2000'],
        ]);

        $response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-5.2')
            ->withSystemPrompt('You are a helpful assistant. Answer concisely and clearly.')
            ->withPrompt($data['prompt'])
            ->asText();

        return response()->json([
            'ok' => true,
            'prompt' => $data['prompt'],
            'answer' => (string) $response->text,
        ]);
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
