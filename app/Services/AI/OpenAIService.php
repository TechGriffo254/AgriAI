<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected string $apiKey;

    protected ?string $organization;

    protected string $model;

    protected int $maxTokens;

    protected float $temperature;

    protected string $baseUrl;

    public function __construct()
    {
        $config = config('llm.providers.openai');

        $this->apiKey = $config['api_key'] ?? '';
        $this->organization = $config['organization'] ?? null;
        $this->model = $config['model'] ?? 'gpt-4o';
        $this->maxTokens = $config['max_tokens'] ?? 4096;
        $this->temperature = $config['temperature'] ?? 0.7;
        $this->baseUrl = 'https://api.openai.com/v1';
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    public function generateText(string $prompt, ?string $systemPrompt = null, array $options = []): array
    {
        $messages = [];

        if ($systemPrompt) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }

        $messages[] = ['role' => 'user', 'content' => $prompt];

        return $this->chat($messages, null, $options);
    }

    public function chat(array $messages, ?string $systemPrompt = null, array $options = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'error' => 'OpenAI API key not configured',
            ];
        }

        $model = $options['model'] ?? $this->model;
        $url = "{$this->baseUrl}/chat/completions";

        $formattedMessages = [];

        if ($systemPrompt) {
            $formattedMessages[] = [
                'role' => 'system',
                'content' => $systemPrompt,
            ];
        }

        foreach ($messages as $message) {
            $formattedMessages[] = [
                'role' => $message['role'],
                'content' => $message['content'],
            ];
        }

        $requestBody = [
            'model' => $model,
            'messages' => $formattedMessages,
            'temperature' => $options['temperature'] ?? $this->temperature,
            'max_tokens' => $options['max_tokens'] ?? $this->maxTokens,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->apiKey}",
        ];

        if (! empty($this->organization)) {
            $headers['OpenAI-Organization'] = $this->organization;
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout(120)
                ->withHeaders($headers)
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                Log::error('OpenAI Chat API Error', [
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
            $text = $data['choices'][0]['message']['content'] ?? '';
            $usage = $data['usage'] ?? [];

            return [
                'success' => true,
                'text' => $text,
                'model' => $model,
                'provider' => 'openai',
                'prompt_tokens' => $usage['prompt_tokens'] ?? 0,
                'completion_tokens' => $usage['completion_tokens'] ?? 0,
                'total_tokens' => $usage['total_tokens'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            Log::error('OpenAI Chat Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
