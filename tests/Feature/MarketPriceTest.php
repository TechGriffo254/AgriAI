<?php

use App\Livewire\Market\Create;
use App\Livewire\Market\Edit;
use App\Livewire\Market\Index;
use App\Livewire\Market\Show;
use App\Models\MarketPrice;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Market Price Index', function () {
    it('displays market prices page for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('market.index'))
            ->assertOk()
            ->assertSeeLivewire(Index::class);
    });

    it('redirects unauthenticated users to login', function () {
        $this->get(route('market.index'))
            ->assertRedirect(route('login'));
    });

    it('displays market prices in table', function () {
        $price = MarketPrice::factory()->create([
            'commodity' => 'Test Maize',
            'price' => 100,
        ]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSee('Test Maize')
            ->assertSee('100');
    });

    it('can filter prices by commodity', function () {
        MarketPrice::factory()->create([
            'commodity' => 'Maize',
            'market_name' => 'Maize Market',
        ]);
        MarketPrice::factory()->create([
            'commodity' => 'Beans',
            'market_name' => 'Beans Market',
        ]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('commodity', 'Maize')
            ->assertSee('Maize Market')
            ->assertDontSee('Beans Market');
    });

    it('can search prices', function () {
        MarketPrice::factory()->create(['commodity' => 'Maize', 'market_name' => 'Wakulima']);
        MarketPrice::factory()->create(['commodity' => 'Rice', 'market_name' => 'Gikomba']);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('search', 'Wakulima')
            ->assertSee('Wakulima')
            ->assertDontSee('Gikomba');
    });

    it('can sort prices', function () {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('sortBy', 'price')
            ->assertSet('sortBy', 'price')
            ->assertSet('sortDir', 'asc');
    });

    it('can delete a price', function () {
        $price = MarketPrice::factory()->create();

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('delete', $price)
            ->assertSuccessful();

        $this->assertDatabaseMissing('market_prices', ['id' => $price->id]);
    });
});

describe('Market Price Create', function () {
    it('displays create form', function () {
        $this->actingAs($this->user)
            ->get(route('market.create'))
            ->assertOk()
            ->assertSeeLivewire(Create::class);
    });

    it('can create a market price', function () {
        Livewire::actingAs($this->user)
            ->test(Create::class)
            ->set('commodity', 'Maize')
            ->set('marketName', 'Wakulima Market')
            ->set('price', 50)
            ->set('unit', 'kg')
            ->set('priceDate', now()->format('Y-m-d'))
            ->call('save')
            ->assertRedirect(route('market.index'));

        $this->assertDatabaseHas('market_prices', [
            'commodity' => 'Maize',
            'market_name' => 'Wakulima Market',
            'price' => 50,
        ]);
    });

    it('validates required fields', function () {
        Livewire::actingAs($this->user)
            ->test(Create::class)
            ->set('commodity', '')
            ->set('marketName', '')
            ->set('price', -1)
            ->call('save')
            ->assertHasErrors(['commodity', 'marketName', 'price' => 'min']);
    });

    it('calculates price change from previous entry', function () {
        // Create previous price
        MarketPrice::factory()->create([
            'commodity' => 'Maize',
            'market_name' => 'Wakulima Market',
            'price' => 40,
            'price_date' => now()->subDay(),
        ]);

        Livewire::actingAs($this->user)
            ->test(Create::class)
            ->set('commodity', 'Maize')
            ->set('marketName', 'Wakulima Market')
            ->set('price', 50)
            ->set('unit', 'kg')
            ->set('priceDate', now()->format('Y-m-d'))
            ->call('save');

        $latestPrice = MarketPrice::where('commodity', 'Maize')
            ->where('market_name', 'Wakulima Market')
            ->orderBy('price_date', 'desc')
            ->first();

        expect($latestPrice->price_change)->toBe(10.0);
        expect($latestPrice->price_change_percent)->toBe(25.0);
    });
});

describe('Market Price Show', function () {
    it('displays price details', function () {
        $price = MarketPrice::factory()->create([
            'commodity' => 'Test Commodity',
            'market_name' => 'Test Market',
            'price' => 150,
        ]);

        $this->actingAs($this->user)
            ->get(route('market.show', $price))
            ->assertOk()
            ->assertSeeLivewire(Show::class)
            ->assertSee('Test Commodity')
            ->assertSee('Test Market');
    });

    it('shows price history', function () {
        // Create multiple prices for same commodity/market
        $commodity = 'Maize';
        $market = 'Wakulima Market';

        MarketPrice::factory()->count(5)->create([
            'commodity' => $commodity,
            'market_name' => $market,
        ]);

        $price = MarketPrice::where('commodity', $commodity)->first();

        Livewire::actingAs($this->user)
            ->test(Show::class, ['marketPrice' => $price])
            ->assertSee('Price History');
    });

    it('can delete price from show page', function () {
        $price = MarketPrice::factory()->create();

        Livewire::actingAs($this->user)
            ->test(Show::class, ['marketPrice' => $price])
            ->call('delete')
            ->assertRedirect(route('market.index'));

        $this->assertDatabaseMissing('market_prices', ['id' => $price->id]);
    });
});

describe('Market Price Edit', function () {
    it('displays edit form with existing data', function () {
        $price = MarketPrice::factory()->create([
            'commodity' => 'Maize',
            'price' => 100,
        ]);

        Livewire::actingAs($this->user)
            ->test(Edit::class, ['marketPrice' => $price])
            ->assertSet('commodity', 'Maize')
            ->assertSet('price', 100.0);
    });

    it('can update a market price', function () {
        $price = MarketPrice::factory()->create([
            'commodity' => 'Maize',
            'price' => 100,
        ]);

        Livewire::actingAs($this->user)
            ->test(Edit::class, ['marketPrice' => $price])
            ->set('price', 150)
            ->call('save')
            ->assertRedirect(route('market.show', $price));

        $this->assertDatabaseHas('market_prices', [
            'id' => $price->id,
            'price' => 150,
        ]);
    });

    it('validates required fields on update', function () {
        $price = MarketPrice::factory()->create();

        Livewire::actingAs($this->user)
            ->test(Edit::class, ['marketPrice' => $price])
            ->set('commodity', '')
            ->set('price', -1)
            ->call('save')
            ->assertHasErrors(['commodity', 'price' => 'min']);
    });
});

