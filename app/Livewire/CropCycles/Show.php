<?php

namespace App\Livewire\CropCycles;

use App\Models\CropCycle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Show extends Component
{
    use AuthorizesRequests;

    public CropCycle $cropCycle;

    public function mount(CropCycle $cropCycle): void
    {
        $this->authorize('view', $cropCycle);
        $this->cropCycle = $cropCycle;
    }

    public function markAsHarvested(): void
    {
        $this->authorize('update', $this->cropCycle);

        $this->cropCycle->update([
            'status' => 'harvested',
            'actual_harvest_date' => now(),
        ]);

        $this->dispatch('crop-cycle-updated');
    }

    public function updateYield(float $actualYield): void
    {
        $this->authorize('update', $this->cropCycle);

        $this->cropCycle->update([
            'actual_yield' => $actualYield,
        ]);

        $this->dispatch('crop-cycle-updated');
    }

    public function deleteCropCycle(): void
    {
        $this->authorize('delete', $this->cropCycle);

        $this->cropCycle->delete();

        session()->flash('success', 'Crop cycle deleted successfully!');

        $this->redirect(route('crop-cycles.index'), navigate: true);
    }

    public function render()
    {
        $this->cropCycle->load(['farm', 'crop', 'tasks' => fn ($q) => $q->latest()->limit(5)]);

        $daysRemaining = null;
        $progress = 0;

        if ($this->cropCycle->planting_date && $this->cropCycle->expected_harvest_date) {
            $totalDays = $this->cropCycle->planting_date->diffInDays($this->cropCycle->expected_harvest_date);
            $daysPassed = $this->cropCycle->planting_date->diffInDays(now());
            $daysRemaining = max(0, $this->cropCycle->expected_harvest_date->diffInDays(now(), false));
            $progress = $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : 0;
        }

        return view('livewire.crop-cycles.show', [
            'daysRemaining' => $daysRemaining,
            'progress' => $progress,
        ])->title($this->cropCycle->name ?? 'Crop Cycle');
    }
}
