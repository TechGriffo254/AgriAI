<?php

namespace App\Livewire\Tasks;

use App\Models\CropCycle;
use App\Models\Farm;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Create Task')]
class Create extends Component
{
    public ?Farm $farm = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:5000')]
    public ?string $description = null;

    #[Validate('nullable|exists:farms,id')]
    public ?int $farm_id = null;

    #[Validate('nullable|exists:crop_cycles,id')]
    public ?int $crop_cycle_id = null;

    #[Validate('required|in:planting,watering,fertilizing,harvesting,pest_control,maintenance,other')]
    public string $category = 'other';

    #[Validate('required|in:low,medium,high,urgent')]
    public string $priority = 'medium';

    #[Validate('nullable|date')]
    public ?string $due_date = null;

    #[Validate('nullable|string')]
    public ?string $due_time = null;

    #[Validate('boolean')]
    public bool $reminder_enabled = false;

    #[Validate('nullable|integer|min:5')]
    public ?int $reminder_minutes_before = 60;

    public function mount(?Farm $farm = null): void
    {
        if ($farm && $farm->exists) {
            $this->farm = $farm;
            $this->farm_id = $farm->id;
        }
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        // Verify farm ownership if provided
        if ($this->farm_id) {
            $farm = $user->farms()->find($this->farm_id);
            if (! $farm) {
                $this->addError('farm_id', 'Invalid farm selected.');

                return;
            }
        }

        // Verify crop cycle ownership if provided
        if ($this->crop_cycle_id) {
            $cropCycle = CropCycle::where('farm_id', $this->farm_id)->find($this->crop_cycle_id);
            if (! $cropCycle) {
                $this->addError('crop_cycle_id', 'Invalid crop cycle selected.');

                return;
            }
        }

        Task::create([
            'user_id' => $user->id,
            'farm_id' => $this->farm_id,
            'crop_cycle_id' => $this->crop_cycle_id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => 'pending',
            'due_date' => $this->due_date,
            'due_time' => $this->due_time,
            'reminder_enabled' => $this->reminder_enabled,
            'reminder_minutes_before' => $this->reminder_minutes_before ?? 60,
        ]);

        session()->flash('success', 'Task created successfully.');

        $this->redirect(route('tasks.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farm_id
            ? CropCycle::where('farm_id', $this->farm_id)->pluck('name', 'id')
            : collect();

        return view('livewire.tasks.create', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
