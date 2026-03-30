<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;

    protected string $model;

    protected string $baseUrl;

    protected int $maxTokens;

    protected float $temperature;

    public function __construct()
    {
        $config = config('llm.providers.groq');

        $this->apiKey = $config['api_key'] ?? '';
        $this->model = $config['model'] ?? 'llama-3.3-70b-versatile';
        $this->baseUrl = $config['base_url'] ?? 'https://api.groq.com/openai/v1';
        $this->maxTokens = $config['max_tokens'] ?? 8192;
        $this->temperature = $config['temperature'] ?? 0.7;
    }

    /**
     * Check if the service is configured
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * Generate a text response from Groq
     */
    public function generateText(string $prompt, ?string $systemPrompt = null, array $options = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'error' => 'Groq API key not configured',
            ];
        }

        $model = $options['model'] ?? $this->model;
        $url = "{$this->baseUrl}/chat/completions";

        $messages = [];

        // Add system message if provided
        if ($systemPrompt) {
            $messages[] = [
                'role' => 'system',
                'content' => $systemPrompt,
            ];
        }

        // Add user message
        $messages[] = [
            'role' => 'user',
            'content' => $prompt,
        ];

        $requestBody = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => $options['temperature'] ?? $this->temperature,
            'max_tokens' => $options['max_tokens'] ?? $this->maxTokens,
            'top_p' => $options['top_p'] ?? 0.95,
        ];

        $startTime = microtime(true);

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$this->apiKey}",
                ])
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                Log::error('Groq API Error', [
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

            // Extract token usage
            $usage = $data['usage'] ?? [];

            return [
                'success' => true,
                'text' => $text,
                'model' => $model,
                'provider' => 'groq',
                'prompt_tokens' => $usage['prompt_tokens'] ?? 0,
                'completion_tokens' => $usage['completion_tokens'] ?? 0,
                'total_tokens' => $usage['total_tokens'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            Log::error('Groq Service Exception', [
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
     * Chat with conversation history
     */
    public function chat(array $messages, ?string $systemPrompt = null, array $options = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'error' => 'Groq API key not configured',
            ];
        }

        $model = $options['model'] ?? $this->model;
        $url = "{$this->baseUrl}/chat/completions";

        $formattedMessages = [];

        // Add system message if provided
        if ($systemPrompt) {
            $formattedMessages[] = [
                'role' => 'system',
                'content' => $systemPrompt,
            ];
        }

        // Convert messages to OpenAI format
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
            'top_p' => $options['top_p'] ?? 0.95,
        ];

        $startTime = microtime(true);

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$this->apiKey}",
                ])
                ->post($url, $requestBody);

            $responseTime = (int) ((microtime(true) - $startTime) * 1000);

            if ($response->failed()) {
                Log::error('Groq Chat API Error', [
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
                'provider' => 'groq',
                'prompt_tokens' => $usage['prompt_tokens'] ?? 0,
                'completion_tokens' => $usage['completion_tokens'] ?? 0,
                'total_tokens' => $usage['total_tokens'] ?? 0,
                'response_time_ms' => $responseTime,
            ];
        } catch (\Exception $e) {
            Log::error('Groq Chat Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
