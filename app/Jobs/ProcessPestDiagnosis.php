<?php

namespace App\Jobs;

use App\Models\PestDiagnosis;
use App\Models\User;
use App\Services\AI\AgriAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessPestDiagnosis implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 30;

    public int $timeout = 180;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public PestDiagnosis $diagnosis,
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AgriAIService $aiService): void
    {
        Log::info('Processing pest diagnosis', ['id' => $this->diagnosis->id]);

        try {
            // Update status to processing
            $this->diagnosis->update(['status' => 'processing']);

            // Call AI service
            $result = $aiService->diagnosePestOrDisease(
                $this->diagnosis->image_path,
                $this->diagnosis->symptoms_description,
                $this->diagnosis->crop_name,
                $this->user
            );

            if ($result['success']) {
                // Try to parse JSON response
                $analysisData = $this->parseAIResponse($result['text']);

                $this->diagnosis->update([
                    'status' => 'completed',
                    'identified_issue' => $analysisData['identified_issue'] ?? null,
                    'scientific_name' => $analysisData['scientific_name'] ?? null,
                    'confidence_score' => $this->parseConfidence($analysisData['confidence'] ?? 'medium'),
                    'severity' => $analysisData['severity'] ?? 'moderate',
                    'description' => $analysisData['description'] ?? $result['text'],
                    'treatment_options' => $analysisData['treatment_options'] ?? [],
                    'prevention_measures' => $analysisData['prevention_measures'] ?? [],
                    'analyzed_at' => now(),
                    'metadata' => [
                        'model' => $result['model'],
                        'tokens' => $result['total_tokens'],
                        'response_time' => $result['response_time_ms'],
                    ],
                ]);

                Log::info('Pest diagnosis completed', ['id' => $this->diagnosis->id]);
            } else {
                $this->diagnosis->update([
                    'status' => 'failed',
                    'additional_notes' => $result['error'] ?? 'Analysis failed',
                ]);

                Log::error('Pest diagnosis failed', [
                    'id' => $this->diagnosis->id,
                    'error' => $result['error'],
                ]);
            }
        } catch (\Exception $e) {
            $this->diagnosis->update([
                'status' => 'failed',
                'additional_notes' => $e->getMessage(),
            ]);

            Log::error('Pest diagnosis exception', [
                'id' => $this->diagnosis->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Parse AI response to extract structured data
     */
    protected function parseAIResponse(string $response): array
    {
        // Try to extract JSON from response
        if (preg_match('/\{[\s\S]*\}/', $response, $matches)) {
            try {
                $data = json_decode($matches[0], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $data;
                }
            } catch (\Exception $e) {
                // Continue to parse manually
            }
        }

        // Manual parsing as fallback
        return [
            'description' => $response,
        ];
    }

    /**
     * Parse confidence string to float
     */
    protected function parseConfidence(string $confidence): float
    {
        return match (strtolower($confidence)) {
            'high' => 0.9,
            'medium' => 0.7,
            'low' => 0.5,
            default => 0.6,
        };
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        $this->diagnosis->update([
            'status' => 'failed',
            'additional_notes' => 'Job failed: '.$exception->getMessage(),
        ]);
    }
}
