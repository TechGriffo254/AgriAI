<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Task Details')]
class Show extends Component
{
    public Task $task;

    public function mount(Task $task): void
    {
        $this->authorize('view', $task);

        $this->task = $task->load(['farm', 'cropCycle']);
    }

    public function toggleComplete(): void
    {
        $this->authorize('update', $this->task);

        if ($this->task->status === 'completed') {
            $this->task->update([
                'status' => 'pending',
                'completed_at' => null,
            ]);
        } else {
            $this->task->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        $this->task->refresh();
    }

    public function updateStatus(string $status): void
    {
        $this->authorize('update', $this->task);

        $completedAt = $this->task->completed_at;
        if ($status === 'completed' && $this->task->status !== 'completed') {
            $completedAt = now();
        } elseif ($status !== 'completed') {
            $completedAt = null;
        }

        $this->task->update([
            'status' => $status,
            'completed_at' => $completedAt,
        ]);

        $this->task->refresh();
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
        return view('livewire.tasks.show');
    }
}
