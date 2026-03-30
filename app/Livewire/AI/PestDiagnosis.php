<?php

namespace App\Livewire\AI;

use App\Models\PestDiagnosis as PestDiagnosisModel;
use App\Services\AI\AgriAIService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Pest & Disease Diagnosis')]
class PestDiagnosis extends Component
{
    use WithFileUploads;

    #[Validate('required|image|max:10240')]
    public $image = null;

    #[Validate('required|string|max:1000')]
    public string $symptoms = '';

    #[Validate('nullable|string|max:100')]
    public string $cropName = '';

    #[Validate('nullable|exists:farms,id')]
    public ?int $farmId = null;

    public bool $isProcessing = false;

    public ?int $currentDiagnosisId = null;

    protected AgriAIService $aiService;

    public function boot(AgriAIService $aiService): void
    {
        $this->aiService = $aiService;
    }

    public function submitDiagnosis(): void
    {
        $this->validate();

        $user = Auth::user();

        // Store the image
        $imagePath = $this->image->store('pest-images', 'public');

        // Create diagnosis record
        $diagnosis = PestDiagnosisModel::create([
            'user_id' => $user->id,
            'farm_id' => $this->farmId,
            'crop_name' => $this->cropName,
            'symptoms_description' => $this->symptoms,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        $this->currentDiagnosisId = $diagnosis->id;
        $this->isProcessing = true;

        // Process synchronously for immediate feedback (change to dispatch for background processing)
        $this->processDiagnosisSync($diagnosis, $user);

        // Reset form
        $this->image = null;
        $this->symptoms = '';
        $this->cropName = '';
    }

    protected function processDiagnosisSync(PestDiagnosisModel $diagnosis, $user): void
    {
        try {
            $diagnosis->update(['status' => 'processing']);

            $result = $this->aiService->diagnosePestOrDisease(
                $diagnosis->image_path,
                $diagnosis->symptoms_description,
                $diagnosis->crop_name,
                $user
            );

            if ($result['success']) {
                $analysisData = $this->parseAIResponse($result['text']);

                $diagnosis->update([
                    'status' => 'completed',
                    'identified_issue' => $analysisData['identified_issue'] ?? 'Analysis Complete',
                    'scientific_name' => $analysisData['scientific_name'] ?? null,
                    'confidence_score' => $this->parseConfidence($analysisData['confidence'] ?? 'medium'),
                    'severity' => $analysisData['severity'] ?? 'moderate',
                    'description' => $analysisData['description'] ?? $result['text'],
                    'treatment_options' => $analysisData['treatment_options'] ?? [],
                    'prevention_measures' => $analysisData['prevention_measures'] ?? [],
                    'analyzed_at' => now(),
                ]);

                session()->flash('success', 'Diagnosis completed successfully!');
            } else {
                $errorMsg = $result['error'] ?? 'Unknown error';

                // Check for quota exceeded error
                if (str_contains($errorMsg, 'quota') || str_contains($errorMsg, 'exceeded')) {
                    $errorMsg = 'AI service is temporarily unavailable due to high demand. Please try again in a few minutes.';
                }

                $diagnosis->update([
                    'status' => 'failed',
                    'additional_notes' => $errorMsg,
                ]);

                session()->flash('error', 'Analysis failed: '.$errorMsg);
            }
        } catch (\Exception $e) {
            $diagnosis->update([
                'status' => 'failed',
                'additional_notes' => $e->getMessage(),
            ]);

            session()->flash('error', 'An error occurred during analysis. Please try again.');
        }

        $this->isProcessing = false;
    }

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
                // Continue to return raw response
            }
        }

        return ['description' => $response];
    }

    protected function parseConfidence(string $confidence): float
    {
        return match (strtolower($confidence)) {
            'high' => 0.9,
            'medium' => 0.7,
            'low' => 0.5,
            default => 0.6,
        };
    }

    public function checkStatus(): void
    {
        if ($this->currentDiagnosisId) {
            $diagnosis = PestDiagnosisModel::find($this->currentDiagnosisId);
            if ($diagnosis && $diagnosis->status === 'completed') {
                $this->isProcessing = false;
            }
        }
    }

    public function viewDiagnosis(int $id): void
    {
        $this->currentDiagnosisId = $id;
    }

    public function deleteDiagnosis(int $id): void
    {
        $diagnosis = PestDiagnosisModel::where('user_id', Auth::id())->find($id);
        if ($diagnosis) {
            $diagnosis->delete();
            if ($this->currentDiagnosisId === $id) {
                $this->currentDiagnosisId = null;
            }
        }
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');

        $diagnoses = PestDiagnosisModel::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $currentDiagnosis = $this->currentDiagnosisId
            ? PestDiagnosisModel::find($this->currentDiagnosisId)
            : null;

        return view('livewire.ai.pest-diagnosis', [
            'farms' => $farms,
            'diagnoses' => $diagnoses,
            'currentDiagnosis' => $currentDiagnosis,
        ]);
    }
}
