<?php

use App\Livewire\Weather;
use App\Models\Farm;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->farm = Farm::factory()->create([
        'user_id' => $this->user->id,
        'latitude' => -1.2921,
        'longitude' => 36.8219,
    ]);
});

test('weather page is accessible to authenticated users', function () {
    $this->actingAs($this->user)
        ->get(route('weather.index'))
        ->assertSuccessful()
        ->assertSeeLivewire(Weather\Index::class);
});

test('weather page redirects guests to login', function () {
    $this->get(route('weather.index'))
        ->assertRedirect(route('login'));
});

test('user can see their farms in the selector', function () {
    Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->assertSee($this->farm->name);
});

test('selecting a farm loads weather data', function () {
    Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->set('selectedFarmId', $this->farm->id)
        ->assertSet('selectedFarmId', (string) $this->farm->id);
});

test('weather shows mock data when no api key configured', function () {
    config(['weather.providers.openweathermap.api_key' => null]);

    Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->set('selectedFarmId', $this->farm->id)
        ->call('fetchWeather')
        ->assertSet('error', null)
        ->assertNotNull('currentWeather');
});

test('weather shows error when farm has no coordinates', function () {
    $farmWithoutCoords = Farm::factory()->create([
        'user_id' => $this->user->id,
        'latitude' => null,
        'longitude' => null,
    ]);

    Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->set('selectedFarmId', $farmWithoutCoords->id)
        ->call('fetchWeather')
        ->assertSet('error', 'Farm location not set. Please update your farm with GPS coordinates.');
});

test('weather displays current conditions', function () {
    config(['weather.providers.openweathermap.api_key' => null]);

    $component = Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->set('selectedFarmId', $this->farm->id)
        ->call('fetchWeather');

    expect($component->get('currentWeather'))->not->toBeNull();
    expect($component->get('currentWeather'))->toHaveKeys([
        'temperature',
        'feels_like',
        'humidity',
        'wind_speed',
        'description',
    ]);
});

test('weather displays 5-day forecast', function () {
    config(['weather.providers.openweathermap.api_key' => null]);

    $component = Livewire::actingAs($this->user)
        ->test(Weather\Index::class)
        ->set('selectedFarmId', $this->farm->id)
        ->call('fetchWeather');

    expect($component->get('forecast'))->not->toBeNull();
    expect($component->get('forecast'))->toHaveCount(5);
});
