<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Edit Task')]
class Edit extends Component
{
    public Task $task;

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

    #[Validate('required|in:pending,in_progress,completed,cancelled')]
    public string $status = 'pending';

    #[Validate('nullable|date')]
    public ?string $due_date = null;

    #[Validate('nullable|string')]
    public ?string $due_time = null;

    #[Validate('boolean')]
    public bool $reminder_enabled = false;

    #[Validate('nullable|integer|min:5')]
    public ?int $reminder_minutes_before = 60;

    public function mount(Task $task): void
    {
        $this->authorize('update', $task);

        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->farm_id = $task->farm_id;
        $this->crop_cycle_id = $task->crop_cycle_id;
        $this->category = $task->category;
        $this->priority = $task->priority;
        $this->status = $task->status;
        $this->due_date = $task->due_date?->format('Y-m-d');
        $this->due_time = $task->due_time;
        $this->reminder_enabled = $task->reminder_enabled ?? false;
        $this->reminder_minutes_before = $task->reminder_minutes_before ?? 60;
    }

    public function save(): void
    {
        $this->authorize('update', $this->task);
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
            $cropCycle = $user->cropCycles()->find($this->crop_cycle_id);
            if (! $cropCycle) {
                $this->addError('crop_cycle_id', 'Invalid crop cycle selected.');

                return;
            }
        }

        $completedAt = $this->task->completed_at;
        if ($this->status === 'completed' && $this->task->status !== 'completed') {
            $completedAt = now();
        } elseif ($this->status !== 'completed') {
            $completedAt = null;
        }

        $this->task->update([
            'farm_id' => $this->farm_id,
            'crop_cycle_id' => $this->crop_cycle_id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'due_time' => $this->due_time,
            'completed_at' => $completedAt,
            'reminder_enabled' => $this->reminder_enabled,
            'reminder_minutes_before' => $this->reminder_enabled ? $this->reminder_minutes_before : null,
        ]);

        session()->flash('success', 'Task updated successfully.');

        $this->redirect(route('tasks.show', $this->task), navigate: true);
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->task);

        $this->task->delete();

        session()->flash('success', 'Task deleted successfully.');

        $this->redirect(route('tasks.index'), navigate: true);
    }

    public function render()
    {
        $user = Auth::user();
        $farms = $user->farms()->pluck('name', 'id');
        $cropCycles = $this->farm_id
            ? $user->cropCycles()->where('farm_id', $this->farm_id)->pluck('name', 'id')
            : collect();

        return view('livewire.tasks.edit', [
            'farms' => $farms,
            'cropCycles' => $cropCycles,
        ]);
    }
}
