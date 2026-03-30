<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;

    protected string $model;

    protected string $visionModel;

    protected string $baseUrl;

    protected int $maxTokens;

    protected float $temperature;

    public function __construct()
    {
        $config = config('llm.providers.gemini');

        $this->apiKey = $config['api_key'] ?? '';
        $this->model = $config['model'] ?? 'gemini-2.0-flash';
        $this->visionModel = $config['vision_model'] ?? 'gemini-2.0-flash';
        $this->baseUrl = $config['base_url'] ?? 'https://generativelanguage.googleapis.com/v1beta';
        $this->maxTokens = $config['max_tokens'] ?? 8192;
        $this->temperature = $config['temperature'] ?? 0.7;
    }

    /**
     * Generate a text response from Gemini
     */
    public function generateText(string $prompt, ?string $systemPrompt = null, array $options = []): array
    {
        $model = $options['model'] ?? $this->model;
        $url = "{$this->baseUrl}/models/{$model}:generateContent?key={$this->apiKey}";

        $contents = [];

        // Add system instruction if provided
        $systemInstruction = $systemPrompt ?? $options['system_prompt'] ?? null;

        // Build the request content
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $prompt]],
        ];

        $requestBody = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => $options['temperature'] ?? $this->temperature,
                'maxOutputTokens' => $options['max_tokens'] ?? $this->maxTokens,
                'topP' => $options['top_p'] ?? 0.95,
                'topK' => $options['top_k'] ?? 40,
            ],
        ];

        if ($systemInstruction) {
            $requestBody['systemInstruction'] = [
                'parts' => [['text' => $systemInstruction]],
            ];
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => $response->json('error.message') ?? 'API request failed',
                    'status' => $response->status(),
                ];
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Extract token usage if available
            $usageMetadata = $data['usageMetadata'] ?? [];

            return [
                'success' => true,
                'text' => $text,
                'model' => $model,
                'provider' => 'gemini',
                'prompt_tokens' => $usageMetadata['promptTokenCount'] ?? 0,
                'completion_tokens' => $usageMetadata['candidatesTokenCount'] ?? 0,
                'total_tokens' => $usageMetadata['totalTokenCount'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate a response with image analysis (vision)
     */
    public function analyzeImage(string $prompt, string $imagePath, ?string $systemPrompt = null, array $options = []): array
    {
        $model = $options['model'] ?? $this->visionModel;
        $url = "{$this->baseUrl}/models/{$model}:generateContent?key={$this->apiKey}";

        // Read and encode the image
        $imageData = $this->getImageData($imagePath);
        if (! $imageData) {
            return [
                'success' => false,
                'error' => 'Failed to read image file',
            ];
        }

        $parts = [
            ['text' => $prompt],
            [
                'inlineData' => [
                    'mimeType' => $imageData['mime_type'],
                    'data' => $imageData['base64'],
                ],
            ],
        ];

        $requestBody = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => $parts,
                ],
            ],
            'generationConfig' => [
                'temperature' => $options['temperature'] ?? $this->temperature,
                'maxOutputTokens' => $options['max_tokens'] ?? $this->maxTokens,
                'topP' => $options['top_p'] ?? 0.95,
                'topK' => $options['top_k'] ?? 40,
            ],
        ];

        if ($systemPrompt) {
            $requestBody['systemInstruction'] = [
                'parts' => [['text' => $systemPrompt]],
            ];
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout(180)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                Log::error('Gemini Vision API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => $response->json('error.message') ?? 'API request failed',
                    'status' => $response->status(),
                ];
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $usageMetadata = $data['usageMetadata'] ?? [];

            return [
                'success' => true,
                'text' => $text,
                'model' => $model,
                'provider' => 'gemini',
                'prompt_tokens' => $usageMetadata['promptTokenCount'] ?? 0,
                'completion_tokens' => $usageMetadata['candidatesTokenCount'] ?? 0,
                'total_tokens' => $usageMetadata['totalTokenCount'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            Log::error('Gemini Vision Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Chat with conversation history
     */
    public function chat(array $messages, ?string $systemPrompt = null, array $options = []): array
    {
        $model = $options['model'] ?? $this->model;
        $url = "{$this->baseUrl}/models/{$model}:generateContent?key={$this->apiKey}";

        // Convert messages to Gemini format
        $contents = [];
        foreach ($messages as $message) {
            $role = $message['role'] === 'assistant' ? 'model' : 'user';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $message['content']]],
            ];
        }

        $requestBody = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => $options['temperature'] ?? $this->temperature,
                'maxOutputTokens' => $options['max_tokens'] ?? $this->maxTokens,
                'topP' => $options['top_p'] ?? 0.95,
                'topK' => $options['top_k'] ?? 40,
            ],
        ];

        if ($systemPrompt) {
            $requestBody['systemInstruction'] = [
                'parts' => [['text' => $systemPrompt]],
            ];
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'error' => $response->json('error.message') ?? 'API request failed',
                    'status' => $response->status(),
                ];
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $usageMetadata = $data['usageMetadata'] ?? [];

            return [
                'success' => true,
                'text' => $text,
                'model' => $model,
                'provider' => 'gemini',
                'prompt_tokens' => $usageMetadata['promptTokenCount'] ?? 0,
                'completion_tokens' => $usageMetadata['candidatesTokenCount'] ?? 0,
                'total_tokens' => $usageMetadata['totalTokenCount'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get image data for API request
     */
    protected function getImageData(string $path): ?array
    {
        try {
            // Handle URL vs local file
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                $imageContent = file_get_contents($path);
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageContent);
            } else {
                // Local file or storage path
                $fullPath = str_starts_with($path, '/') ? $path : storage_path("app/public/{$path}");
                if (! file_exists($fullPath)) {
                    return null;
                }
                $imageContent = file_get_contents($fullPath);
                $mimeType = mime_content_type($fullPath);
            }

            return [
                'base64' => base64_encode($imageContent),
                'mime_type' => $mimeType,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to read image', ['path' => $path, 'error' => $e->getMessage()]);

            return null;
        }
    }
}
