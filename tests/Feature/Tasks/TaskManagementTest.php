<?php

use App\Livewire\Tasks;
use App\Models\Farm;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->farm = Farm::factory()->create(['user_id' => $this->user->id]);
});

test('tasks index page is accessible to authenticated users', function () {
    $this->actingAs($this->user)
        ->get(route('tasks.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(Tasks\Index::class);
});

test('tasks index page redirects guests to login', function () {
    $this->get(route('tasks.index'))
        ->assertRedirect(route('login'));
});

test('user can see their tasks on index page', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'farm_id' => $this->farm->id,
        'title' => 'Water the tomatoes',
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Index::class)
        ->assertSee('Water the tomatoes');
});

test('user cannot see other users tasks', function () {
    $otherUser = User::factory()->create();
    $otherTask = Task::factory()->create([
        'user_id' => $otherUser->id,
        'title' => 'Other user task',
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Index::class)
        ->assertDontSee('Other user task');
});

test('user can filter tasks by status', function () {
    Task::factory()->pending()->create([
        'user_id' => $this->user->id,
        'title' => 'Pending Task',
    ]);
    Task::factory()->completed()->create([
        'user_id' => $this->user->id,
        'title' => 'Completed Task',
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Index::class)
        ->set('status', 'pending')
        ->assertSee('Pending Task')
        ->assertDontSee('Completed Task');
});

test('user can search tasks', function () {
    Task::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Water the tomatoes',
    ]);
    Task::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Harvest the corn',
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Index::class)
        ->set('search', 'tomatoes')
        ->assertSee('Water the tomatoes')
        ->assertDontSee('Harvest the corn');
});

test('user can toggle task completion', function () {
    $task = Task::factory()->pending()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Index::class)
        ->call('toggleComplete', $task);

    expect($task->fresh()->status)->toBe('completed')
        ->and($task->fresh()->completed_at)->not->toBeNull();
});

test('tasks create page is accessible', function () {
    $this->actingAs($this->user)
        ->get(route('tasks.create'))
        ->assertSuccessful()
        ->assertSeeLivewire(Tasks\Create::class);
});

test('user can create a new task', function () {
    Livewire::actingAs($this->user)
        ->test(Tasks\Create::class)
        ->set('title', 'New Test Task')
        ->set('description', 'Task description')
        ->set('category', 'watering')
        ->set('priority', 'high')
        ->set('farm_id', $this->farm->id)
        ->set('due_date', now()->addDays(3)->format('Y-m-d'))
        ->call('save')
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $this->user->id,
        'title' => 'New Test Task',
        'category' => 'watering',
        'priority' => 'high',
        'status' => 'pending',
    ]);
});

test('task creation requires a title', function () {
    Livewire::actingAs($this->user)
        ->test(Tasks\Create::class)
        ->set('title', '')
        ->set('category', 'watering')
        ->set('priority', 'medium')
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});

test('user can view their task', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'farm_id' => $this->farm->id,
        'title' => 'Test Task Title',
    ]);

    $this->actingAs($this->user)
        ->get(route('tasks.show', $task))
        ->assertSuccessful()
        ->assertSee('Test Task Title');
});

test('user cannot view other users task', function () {
    $otherUser = User::factory()->create();
    $task = Task::factory()->create([
        'user_id' => $otherUser->id,
        'title' => 'Other Task',
    ]);

    $this->actingAs($this->user)
        ->get(route('tasks.show', $task))
        ->assertForbidden();
});

test('user can update their task', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'farm_id' => $this->farm->id,
        'title' => 'Original Title',
        'category' => 'watering',
        'priority' => 'medium',
        'status' => 'pending',
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Edit::class, ['task' => $task])
        ->set('title', 'Updated Title')
        ->set('priority', 'urgent')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('tasks.show', $task));

    expect($task->fresh())
        ->title->toBe('Updated Title')
        ->priority->toBe('urgent');
});

test('user can delete their task', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Show::class, ['task' => $task])
        ->call('delete')
        ->assertRedirect(route('tasks.index'));

    $this->assertSoftDeleted('tasks', ['id' => $task->id]);
});

test('user can update task status from show page', function () {
    $task = Task::factory()->pending()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Show::class, ['task' => $task])
        ->call('updateStatus', 'in_progress');

    expect($task->fresh()->status)->toBe('in_progress');
});

test('completing task sets completed_at timestamp', function () {
    $task = Task::factory()->pending()->create([
        'user_id' => $this->user->id,
    ]);

    Livewire::actingAs($this->user)
        ->test(Tasks\Show::class, ['task' => $task])
        ->call('updateStatus', 'completed');

    expect($task->fresh())
        ->status->toBe('completed')
        ->completed_at->not->toBeNull();
});
