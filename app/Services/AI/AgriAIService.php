<?php

namespace App\Services\AI;

use App\Models\AIConversation;
use App\Models\AIQuery;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AgriAIService
{
    protected GeminiService $gemini;

    protected GroqService $groq;

    public function __construct(GeminiService $gemini, GroqService $groq)
    {
        $this->gemini = $gemini;
        $this->groq = $groq;
    }

    /**
     * Get the chat service (Groq for free, fallback to Gemini)
     */
    protected function getChatService(): GeminiService|GroqService
    {
        $provider = config('llm.chat_provider', 'groq');

        if ($provider === 'groq' && $this->groq->isConfigured()) {
            return $this->groq;
        }

        return $this->gemini;
    }

    /**
     * Get farming advice based on user's question
     */
    public function getFarmingAdvice(string $question, ?array $context = null, ?User $user = null): array
    {
        $user = $user ?? Auth::user();

        $systemPrompt = config('llm.prompts.chat_assistant');

        // Build context-aware prompt
        $prompt = $question;
        if ($context) {
            $contextStr = $this->buildContextString($context);
            $prompt = "Context:\n{$contextStr}\n\nQuestion: {$question}";
        }

        $chatService = $this->getChatService();
        $result = $chatService->generateText($prompt, $systemPrompt);

        // Log the query
        if ($user && $result['success']) {
            $this->logQuery($user, 'chat', $prompt, $result);
        }

        return $result;
    }

    /**
     * Diagnose pest or disease from image
     */
    public function diagnosePestOrDisease(
        string $imagePath,
        string $symptoms,
        ?string $cropName = null,
        ?User $user = null
    ): array {
        $user = $user ?? Auth::user();

        $systemPrompt = config('llm.prompts.pest_diagnosis');

        $prompt = "Please analyze this plant image and identify any pests, diseases, or health issues.\n\n";
        if ($cropName) {
            $prompt .= "Crop: {$cropName}\n";
        }
        $prompt .= "Observed symptoms: {$symptoms}\n\n";
        $prompt .= "Please provide:\n";
        $prompt .= "1. Identified issue (pest, disease, or deficiency)\n";
        $prompt .= "2. Scientific name if applicable\n";
        $prompt .= "3. Confidence level (high/medium/low)\n";
        $prompt .= "4. Severity (mild/moderate/severe)\n";
        $prompt .= "5. Description of the issue\n";
        $prompt .= "6. Treatment options (list at least 3)\n";
        $prompt .= "7. Prevention measures\n\n";
        $prompt .= 'Format your response as JSON with keys: identified_issue, scientific_name, confidence, severity, description, treatment_options (array), prevention_measures (array)';

        $result = $this->gemini->analyzeImage($prompt, $imagePath, $systemPrompt);

        // Fallback: if vision provider is unavailable (e.g. quota), still provide
        // a symptoms-based diagnosis via the configured chat provider.
        if (! $result['success']) {
            $error = strtolower($result['error'] ?? '');
            $shouldFallback = str_contains($error, 'quota')
                || str_contains($error, 'rate limit')
                || str_contains($error, 'unavailable')
                || str_contains($error, 'temporar');

            if ($shouldFallback) {
                $fallbackPrompt = "Image-based diagnosis is temporarily unavailable. ";
                $fallbackPrompt .= "Provide a best-effort diagnosis using symptoms only.\n\n";
                if ($cropName) {
                    $fallbackPrompt .= "Crop: {$cropName}\n";
                }
                $fallbackPrompt .= "Observed symptoms: {$symptoms}\n\n";
                $fallbackPrompt .= "Return JSON with keys: identified_issue, scientific_name, confidence, severity, description, treatment_options (array), prevention_measures (array).";

                $fallback = $this->getChatService()->generateText($fallbackPrompt, $systemPrompt);
                if ($fallback['success']) {
                    $fallback['text'] .= "\n\nNote: This result was generated from symptom text only because image analysis is temporarily unavailable.";
                    $result = $fallback;
                }
            }
        }

        if ($user && $result['success']) {
            $this->logQuery($user, 'pest_diagnosis', $prompt, $result);
        }

        return $result;
    }

    /**
     * Get crop recommendations based on conditions
     */
    public function getCropRecommendations(array $conditions, ?User $user = null): array
    {
        $user = $user ?? Auth::user();

        $systemPrompt = config('llm.prompts.crop_advisor');

        $prompt = "Based on the following conditions, recommend suitable crops:\n\n";
        $prompt .= 'Location: '.($conditions['location'] ?? 'Not specified')."\n";
        $prompt .= 'Soil Type: '.($conditions['soil_type'] ?? 'Not specified')."\n";
        $prompt .= 'Climate: '.($conditions['climate'] ?? 'Not specified')."\n";
        $prompt .= 'Available Water: '.($conditions['water_availability'] ?? 'Not specified')."\n";
        $prompt .= 'Farm Size: '.($conditions['farm_size'] ?? 'Not specified')."\n";
        $prompt .= 'Budget: '.($conditions['budget'] ?? 'Not specified')."\n";
        $prompt .= 'Season: '.($conditions['season'] ?? 'Not specified')."\n";

        if (isset($conditions['preferences'])) {
            $prompt .= 'Preferences: '.$conditions['preferences']."\n";
        }

        $prompt .= "\nProvide detailed recommendations including:\n";
        $prompt .= "1. Top 5 recommended crops with reasons\n";
        $prompt .= "2. Expected yields and timelines\n";
        $prompt .= "3. Initial investment estimates\n";
        $prompt .= "4. Key considerations and risks\n";

        $chatService = $this->getChatService();
        $result = $chatService->generateText($prompt, $systemPrompt);

        if ($user && $result['success']) {
            $this->logQuery($user, 'crop_advisor', $prompt, $result);
        }

        return $result;
    }

    /**
     * Get weather-based farming insights
     */
    public function getWeatherInsights(array $weatherData, ?string $cropType = null, ?User $user = null): array
    {
        $user = $user ?? Auth::user();

        $systemPrompt = config('llm.prompts.weather_insights');

        $prompt = "Analyze the following weather data and provide farming recommendations:\n\n";
        $prompt .= "Current Weather:\n";
        $prompt .= '- Temperature: '.($weatherData['temperature'] ?? 'N/A')."°C\n";
        $prompt .= '- Humidity: '.($weatherData['humidity'] ?? 'N/A')."%\n";
        $prompt .= '- Wind Speed: '.($weatherData['wind_speed'] ?? 'N/A')." km/h\n";
        $prompt .= '- Conditions: '.($weatherData['conditions'] ?? 'N/A')."\n";

        if (isset($weatherData['forecast'])) {
            $prompt .= "\n7-Day Forecast Summary:\n";
            foreach ($weatherData['forecast'] as $day) {
                $prompt .= '- '.($day['date'] ?? '').': '.($day['conditions'] ?? '').', ';
                $prompt .= ($day['temp_high'] ?? '').'°C / '.($day['temp_low'] ?? '')."°C\n";
            }
        }

        if ($cropType) {
            $prompt .= "\nCrop being grown: {$cropType}\n";
        }

        $prompt .= "\nPlease provide:\n";
        $prompt .= "1. Immediate actions to take based on current weather\n";
        $prompt .= "2. Irrigation recommendations\n";
        $prompt .= "3. Pest/disease alerts based on weather conditions\n";
        $prompt .= "4. Upcoming weather impacts to prepare for\n";

        $chatService = $this->getChatService();
        $result = $chatService->generateText($prompt, $systemPrompt);

        if ($user && $result['success']) {
            $this->logQuery($user, 'weather_insights', $prompt, $result);
        }

        return $result;
    }

    /**
     * Chat with conversation context
     */
    public function chat(
        string $message,
        ?AIConversation $conversation = null,
        ?User $user = null
    ): array {
        $user = $user ?? Auth::user();

        $systemPrompt = config('llm.prompts.chat_assistant');

        // Build conversation history
        $messages = [];
        if ($conversation) {
            $previousQueries = $conversation->queries()
                ->orderBy('created_at', 'asc')
                ->limit(10)
                ->get();

            foreach ($previousQueries as $query) {
                if ($query->role === 'user') {
                    $messages[] = ['role' => 'user', 'content' => $query->prompt];
                } else {
                    $messages[] = ['role' => 'assistant', 'content' => $query->response];
                }
            }
        }

        // Add current message
        $messages[] = ['role' => 'user', 'content' => $message];

        $chatService = $this->getChatService();
        $result = $chatService->chat($messages, $systemPrompt);

        // Log the query and update conversation
        if ($user && $result['success']) {
            $query = $this->logQuery($user, 'chat', $message, $result, $conversation);

            if ($conversation) {
                $conversation->update(['last_message_at' => now()]);
            }

            $result['query_id'] = $query->id;
        }

        return $result;
    }

    /**
     * Build context string from array
     */
    protected function buildContextString(array $context): string
    {
        $lines = [];
        foreach ($context as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $lines[] = ucfirst(str_replace('_', ' ', $key)).": {$value}";
        }

        return implode("\n", $lines);
    }

    /**
     * Log AI query to database
     */
    protected function logQuery(
        User $user,
        string $type,
        string $prompt,
        array $result,
        ?AIConversation $conversation = null
    ): AIQuery {
        return AIQuery::create([
            'user_id' => $user->id,
            'ai_conversation_id' => $conversation?->id,
            'type' => $type,
            'provider' => $result['provider'] ?? 'gemini',
            'model' => $result['model'] ?? config('llm.providers.gemini.model'),
            'prompt' => $prompt,
            'response' => $result['text'] ?? null,
            'role' => 'user',
            'prompt_tokens' => $result['prompt_tokens'] ?? 0,
            'completion_tokens' => $result['completion_tokens'] ?? 0,
            'total_tokens' => $result['total_tokens'] ?? 0,
            'response_time_ms' => $result['response_time_ms'] ?? 0,
            'status' => $result['success'] ? 'completed' : 'failed',
            'error_message' => $result['error'] ?? null,
        ]);
    }
}
