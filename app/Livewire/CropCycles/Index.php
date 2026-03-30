<?php

namespace App\Livewire\CropCycles;

use App\Models\CropCycle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Crop Cycles')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $farmId = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFarmId(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $farmIds = $user->farms()->pluck('id');

        $cropCycles = CropCycle::whereIn('farm_id', $farmIds)
            ->with(['farm', 'crop'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('field_section', 'like', "%{$this->search}%")
                        ->orWhereHas('crop', fn ($q) => $q->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->farmId, fn ($query) => $query->where('farm_id', $this->farmId))
            ->latest()
            ->paginate(10);

        return view('livewire.crop-cycles.index', [
            'cropCycles' => $cropCycles,
            'farms' => $user->farms()->get(),
            'statuses' => ['planning', 'active', 'harvested', 'cancelled'],
        ]);
    }
}
