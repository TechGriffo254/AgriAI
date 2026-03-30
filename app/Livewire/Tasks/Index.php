<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Tasks')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $priority = '';

    public string $category = '';

    public string $farmId = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedPriority(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedFarmId(): void
    {
        $this->resetPage();
    }

    public function toggleComplete(Task $task): void
    {
        $this->authorize('update', $task);

        if ($task->status === 'completed') {
            $task->update([
                'status' => 'pending',
                'completed_at' => null,
            ]);
        } else {
            $task->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }
    }

    public function deleteTask(Task $task): void
    {
        $this->authorize('delete', $task);

        $task->delete();

        $this->dispatch('task-deleted');
    }

    public function render()
    {
        $user = Auth::user();

        $tasks = $user->tasks()
            ->with(['farm', 'cropCycle'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->priority, fn ($query) => $query->where('priority', $this->priority))
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->farmId, fn ($query) => $query->where('farm_id', $this->farmId))
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 WHEN status = 'in_progress' THEN 1 ELSE 2 END")
            ->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END')
            ->orderBy('due_date')
            ->orderByRaw("CASE WHEN priority = 'urgent' THEN 0 WHEN priority = 'high' THEN 1 WHEN priority = 'medium' THEN 2 ELSE 3 END")
            ->paginate(12);

        $farms = $user->farms()->pluck('name', 'id');

        $taskCounts = [
            'all' => $user->tasks()->count(),
            'pending' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
            'completed' => $user->tasks()->where('status', 'completed')->count(),
            'overdue' => $user->tasks()
                ->where('status', '!=', 'completed')
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', now())
                ->count(),
        ];

        return view('livewire.tasks.index', [
            'tasks' => $tasks,
            'farms' => $farms,
            'taskCounts' => $taskCounts,
        ]);
    }
}
