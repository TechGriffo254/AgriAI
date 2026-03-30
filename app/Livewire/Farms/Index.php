<?php

namespace App\Livewire\Farms;

use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('My Farms')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function deleteFarm(Farm $farm): void
    {
        $this->authorize('delete', $farm);

        $farm->delete();

        $this->dispatch('farm-deleted');
    }

    public function render()
    {
        $farms = Auth::user()
            ->farms()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('address', 'like', "%{$this->search}%")
                    ->orWhere('city', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(9);

        return view('livewire.farms.index', [
            'farms' => $farms,
        ]);
    }
}
