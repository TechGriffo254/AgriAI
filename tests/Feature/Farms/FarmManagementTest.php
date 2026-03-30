<?php

use App\Models\Farm;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Farm Index', function () {
    it('redirects guests to login', function () {
        $this->get(route('farms.index'))
            ->assertRedirect(route('login'));
    });

    it('shows farms list for authenticated users', function () {
        $this->actingAs($this->user);

        $this->get(route('farms.index'))
            ->assertSuccessful()
            ->assertSee('My Farms');
    });

    it('only shows farms belonging to the authenticated user', function () {
        $myFarm = Farm::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'My Farm',
        ]);

        $otherFarm = Farm::factory()->create([
            'name' => 'Other Farm',
        ]);

        $this->actingAs($this->user);

        $this->get(route('farms.index'))
            ->assertSee('My Farm')
            ->assertDontSee('Other Farm');
    });
});

describe('Farm Creation', function () {
    it('shows create farm form for authenticated users', function () {
        $this->actingAs($this->user);

        $this->get(route('farms.create'))
            ->assertSuccessful()
            ->assertSee('Add New Farm');
    });

    it('can create a new farm', function () {
        $this->actingAs($this->user);

        Livewire::test(\App\Livewire\Farms\Create::class)
            ->set('name', 'Test Farm')
            ->set('description', 'A test farm description')
            ->set('city', 'Nairobi')
            ->set('country', 'Kenya')
            ->set('size', 50.5)
            ->set('sizeUnit', 'acres')
            ->set('soilType', 'Loam')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('farms', [
            'user_id' => $this->user->id,
            'name' => 'Test Farm',
            'city' => 'Nairobi',
            'size' => 50.5,
        ]);
    });

    it('validates required fields', function () {
        $this->actingAs($this->user);

        Livewire::test(\App\Livewire\Farms\Create::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    });
});

describe('Farm View', function () {
    it('can view own farm details', function () {
        $farm = Farm::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Green Valley Farm',
        ]);

        $this->actingAs($this->user);

        $this->get(route('farms.show', $farm))
            ->assertSuccessful()
            ->assertSee('Green Valley Farm');
    });

    it('cannot view another users farm', function () {
        $otherUser = User::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($this->user);

        $this->get(route('farms.show', $farm))
            ->assertForbidden();
    });
});

describe('Farm Edit', function () {
    it('can edit own farm', function () {
        $farm = Farm::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Old Name',
        ]);

        $this->actingAs($this->user);

        Livewire::test(\App\Livewire\Farms\Edit::class, ['farm' => $farm])
            ->set('name', 'New Name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('farms', [
            'id' => $farm->id,
            'name' => 'New Name',
        ]);
    });

    it('cannot edit another users farm', function () {
        $otherUser = User::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($this->user);

        $this->get(route('farms.edit', $farm))
            ->assertForbidden();
    });
});

describe('Farm Delete', function () {
    it('can delete own farm', function () {
        $farm = Farm::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);

        Livewire::test(\App\Livewire\Farms\Show::class, ['farm' => $farm])
            ->call('deleteFarm')
            ->assertRedirect(route('farms.index'));

        $this->assertSoftDeleted('farms', [
            'id' => $farm->id,
        ]);
    });
});
