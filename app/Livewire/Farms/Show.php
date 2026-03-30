<?php

namespace App\Livewire\Farms;

use App\Models\Farm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Show extends Component
{
    use AuthorizesRequests;

    public Farm $farm;

    public function mount(Farm $farm): void
    {
        $this->authorize('view', $farm);
        $this->farm = $farm;
    }

    public function getTitle(): string
    {
        return $this->farm->name;
    }

    public function deleteFarm(): void
    {
        $this->authorize('delete', $this->farm);

        $this->farm->delete();

        session()->flash('success', 'Farm deleted successfully!');

        $this->redirect(route('farms.index'), navigate: true);
    }

    public function render()
    {
        $this->farm->load(['cropCycles.crop', 'tasks' => fn ($q) => $q->where('status', '!=', 'completed')->latest()->limit(5)]);

        return view('livewire.farms.show', [
            'activeCropCycles' => $this->farm->cropCycles()->where('status', 'active')->with('crop')->get(),
            'recentTasks' => $this->farm->tasks()->where('status', '!=', 'completed')->latest()->limit(5)->get(),
            'stats' => [
                'total_crop_cycles' => $this->farm->cropCycles()->count(),
                'active_crop_cycles' => $this->farm->cropCycles()->where('status', 'active')->count(),
                'pending_tasks' => $this->farm->tasks()->where('status', 'pending')->count(),
                'total_expenses' => $this->farm->expenses()->sum('amount'),
                'total_income' => $this->farm->incomes()->sum('amount'),
            ],
        ])->title($this->farm->name);
    }
}
