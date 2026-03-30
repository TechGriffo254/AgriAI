<?php

namespace App\Jobs;

use App\Models\AIConversation;
use App\Models\AIQuery;
use App\Models\User;
use App\Services\AI\AgriAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessAIChat implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 10;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public AIConversation $conversation,
        public AIQuery $query,
        public User $user,
        public string $message
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AgriAIService $aiService): void
    {
        Log::info('Processing AI chat', [
            'conversation_id' => $this->conversation->id,
            'query_id' => $this->query->id,
        ]);

        try {
            // Update query status
            $this->query->update(['status' => 'processing']);

            // Get AI response
            $result = $aiService->chat(
                $this->message,
                $this->conversation,
                $this->user
            );

            if ($result['success']) {
                // Update the query with response
                $this->query->update([
                    'response' => $result['text'],
                    'prompt_tokens' => $result['prompt_tokens'],
                    'completion_tokens' => $result['completion_tokens'],
                    'total_tokens' => $result['total_tokens'],
                    'response_time_ms' => $result['response_time_ms'],
                    'status' => 'completed',
                ]);

                // Create assistant response entry
                AIQuery::create([
                    'user_id' => $this->user->id,
                    'ai_conversation_id' => $this->conversation->id,
                    'type' => 'chat',
                    'provider' => $result['provider'],
                    'model' => $result['model'],
                    'prompt' => null,
                    'response' => $result['text'],
                    'role' => 'assistant',
                    'prompt_tokens' => $result['prompt_tokens'] ?? 0,
                    'completion_tokens' => $result['completion_tokens'] ?? 0,
                    'total_tokens' => $result['total_tokens'] ?? 0,
                    'response_time_ms' => $result['response_time_ms'] ?? 0,
                    'status' => 'completed',
                ]);

                // Update conversation
                $this->conversation->update(['last_message_at' => now()]);

                Log::info('AI chat completed', ['query_id' => $this->query->id]);
            } else {
                $this->query->update([
                    'status' => 'failed',
                    'error_message' => $result['error'] ?? 'Unknown error',
                ]);

                Log::error('AI chat failed', [
                    'query_id' => $this->query->id,
                    'error' => $result['error'],
                ]);
            }
        } catch (\Exception $e) {
            $this->query->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            Log::error('AI chat exception', [
                'query_id' => $this->query->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        $this->query->update([
            'status' => 'failed',
            'error_message' => 'Job failed: '.$exception->getMessage(),
        ]);
    }
}
