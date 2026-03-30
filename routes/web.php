<?php

use App\Livewire\AI;
use App\Livewire\CropCycles;
use App\Livewire\Farms;
use App\Livewire\Finances;
use App\Livewire\Inventory;
use App\Livewire\Market;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Tasks;
use App\Livewire\Weather;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Farm Management Routes
    Route::get('farms', Farms\Index::class)->name('farms.index');
    Route::get('farms/create', Farms\Create::class)->name('farms.create');
    Route::get('farms/{farm}', Farms\Show::class)->name('farms.show');
    Route::get('farms/{farm}/edit', Farms\Edit::class)->name('farms.edit');

    // Crop Cycles Routes
    Route::get('crop-cycles', CropCycles\Index::class)->name('crop-cycles.index');
    Route::get('crop-cycles/create/{farm?}', CropCycles\Create::class)->name('crop-cycles.create');
    Route::get('crop-cycles/{cropCycle}', CropCycles\Show::class)->name('crop-cycles.show');
    Route::get('crop-cycles/{cropCycle}/edit', CropCycles\Edit::class)->name('crop-cycles.edit');

    // Tasks Routes
    Route::get('tasks', Tasks\Index::class)->name('tasks.index');
    Route::get('tasks/create/{farm?}', Tasks\Create::class)->name('tasks.create');
    Route::get('tasks/{task}', Tasks\Show::class)->name('tasks.show');
    Route::get('tasks/{task}/edit', Tasks\Edit::class)->name('tasks.edit');

    // Inventory Routes
    Route::get('inventory', Inventory\Index::class)->name('inventory.index');
    Route::get('inventory/create', Inventory\Create::class)->name('inventory.create');
    Route::get('inventory/{inventory}', Inventory\Show::class)->name('inventory.show');
    Route::get('inventory/{inventory}/edit', Inventory\Edit::class)->name('inventory.edit');

    // Finances Routes
    Route::get('finances', Finances\Index::class)->name('finances.index');
    Route::get('finances/expense/create', Finances\ExpenseCreate::class)->name('finances.expense.create');
    Route::get('finances/expense/{expense}/edit', Finances\ExpenseEdit::class)->name('finances.expense.edit');
    Route::get('finances/income/create', Finances\IncomeCreate::class)->name('finances.income.create');
    Route::get('finances/income/{income}/edit', Finances\IncomeEdit::class)->name('finances.income.edit');

    // AI Routes
    Route::get('ai', AI\Assistant::class)->name('ai.assistant');
    Route::get('ai/chat/{conversation?}', AI\Assistant::class)->name('ai.chat');
    Route::get('ai/pest-diagnosis', AI\PestDiagnosis::class)->name('ai.pest-diagnosis');

    // Weather Routes
    Route::get('weather', Weather\Index::class)->name('weather.index');

    // Market Prices Routes
    Route::get('market', Market\Index::class)->name('market.index');
    Route::get('market/create', Market\Create::class)->name('market.create');
    Route::get('market/{marketPrice}', Market\Show::class)->name('market.show');
    Route::get('market/{marketPrice}/edit', Market\Edit::class)->name('market.edit');

    // Settings Routes
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
