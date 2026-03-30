<?php

namespace App\Livewire\Weather;

use App\Models\Farm;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Weather')]
class Index extends Component
{
    public string $selectedFarmId = '';

    public ?array $currentWeather = null;

    public ?array $forecast = null;

    public bool $loading = false;

    public ?string $error = null;

    public function mount(): void
    {
        $firstFarm = Auth::user()->farms()->first();
        if ($firstFarm) {
            $this->selectedFarmId = (string) $firstFarm->id;
            $this->fetchWeather();
        }
    }

    public function updatedSelectedFarmId(): void
    {
        $this->fetchWeather();
    }

    public function fetchWeather(): void
    {
        if (! $this->selectedFarmId) {
            return;
        }

        $this->loading = true;
        $this->error = null;

        try {
            $farm = Farm::find($this->selectedFarmId);
            if (! $farm || ! $farm->latitude || ! $farm->longitude) {
                $this->error = 'Farm location not set. Please update your farm with GPS coordinates.';
                $this->loading = false;

                return;
            }

            $apiKey = config('weather.providers.openweathermap.api_key');
            if (! $apiKey) {
                // Use mock data for demo
                $this->currentWeather = $this->getMockCurrentWeather($farm);
                $this->forecast = $this->getMockForecast();
                $this->loading = false;

                return;
            }

            // Fetch current weather
            $currentResponse = Http::get(config('weather.providers.openweathermap.base_url').'/weather', [
                'lat' => $farm->latitude,
                'lon' => $farm->longitude,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($currentResponse->successful()) {
                $data = $currentResponse->json();
                $this->currentWeather = [
                    'temperature' => round($data['main']['temp']),
                    'feels_like' => round($data['main']['feels_like']),
                    'humidity' => $data['main']['humidity'],
                    'pressure' => $data['main']['pressure'],
                    'wind_speed' => round($data['wind']['speed'] * 3.6), // m/s to km/h
                    'wind_direction' => $data['wind']['deg'] ?? 0,
                    'description' => ucfirst($data['weather'][0]['description']),
                    'icon' => $data['weather'][0]['icon'],
                    'clouds' => $data['clouds']['all'] ?? 0,
                    'visibility' => ($data['visibility'] ?? 10000) / 1000, // meters to km
                    'sunrise' => $data['sys']['sunrise'] ?? null,
                    'sunset' => $data['sys']['sunset'] ?? null,
                ];

                // Store weather data
                WeatherData::updateOrCreate(
                    [
                        'farm_id' => $farm->id,
                        'data_type' => 'current',
                        'recorded_at' => now()->startOfHour(),
                    ],
                    [
                        'temperature' => $data['main']['temp'],
                        'feels_like' => $data['main']['feels_like'],
                        'humidity' => $data['main']['humidity'],
                        'pressure' => $data['main']['pressure'],
                        'wind_speed' => $data['wind']['speed'],
                        'wind_direction' => $data['wind']['deg'] ?? null,
                        'weather_main' => $data['weather'][0]['main'],
                        'weather_description' => $data['weather'][0]['description'],
                        'weather_icon' => $data['weather'][0]['icon'],
                        'clouds' => $data['clouds']['all'] ?? null,
                        'visibility' => $data['visibility'] ?? null,
                        'source' => 'openweathermap',
                        'raw_data' => $data,
                    ]
                );
            }

            // Fetch 5-day forecast
            $forecastResponse = Http::get(config('weather.providers.openweathermap.base_url').'/forecast', [
                'lat' => $farm->latitude,
                'lon' => $farm->longitude,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($forecastResponse->successful()) {
                $data = $forecastResponse->json();
                $this->forecast = collect($data['list'])
                    ->groupBy(fn ($item) => date('Y-m-d', $item['dt']))
                    ->take(5)
                    ->map(function ($dayData, $date) {
                        $temps = collect($dayData)->pluck('main.temp');
                        $firstItem = $dayData->first();

                        return [
                            'date' => $date,
                            'day' => date('D', strtotime($date)),
                            'temp_min' => round($temps->min()),
                            'temp_max' => round($temps->max()),
                            'description' => $firstItem['weather'][0]['description'],
                            'icon' => $firstItem['weather'][0]['icon'],
                            'humidity' => round(collect($dayData)->avg('main.humidity')),
                            'rain_chance' => round(collect($dayData)->avg('pop') * 100),
                        ];
                    })
                    ->values()
                    ->toArray();
            }
        } catch (\Exception $e) {
            $this->error = 'Failed to fetch weather data. Please try again later.';
        }

        $this->loading = false;
    }

    protected function getMockCurrentWeather(Farm $farm): array
    {
        return [
            'temperature' => 24,
            'feels_like' => 26,
            'humidity' => 65,
            'pressure' => 1013,
            'wind_speed' => 12,
            'wind_direction' => 180,
            'description' => 'Partly cloudy',
            'icon' => '02d',
            'clouds' => 40,
            'visibility' => 10,
            'sunrise' => now()->setTime(6, 30)->timestamp,
            'sunset' => now()->setTime(18, 45)->timestamp,
        ];
    }

    protected function getMockForecast(): array
    {
        $forecasts = [];
        for ($i = 0; $i < 5; $i++) {
            $date = now()->addDays($i);
            $forecasts[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'temp_min' => rand(18, 22),
                'temp_max' => rand(26, 32),
                'description' => ['Sunny', 'Partly cloudy', 'Cloudy', 'Light rain'][rand(0, 3)],
                'icon' => ['01d', '02d', '03d', '10d'][rand(0, 3)],
                'humidity' => rand(50, 80),
                'rain_chance' => rand(0, 60),
            ];
        }

        return $forecasts;
    }

    public function getWeatherIcon(string $icon): string
    {
        return match (substr($icon, 0, 2)) {
            '01' => 'sun',
            '02' => 'cloud-sun',
            '03', '04' => 'cloud',
            '09', '10' => 'cloud-rain',
            '11' => 'cloud-lightning',
            '13' => 'snowflake',
            '50' => 'wind',
            default => 'sun',
        };
    }

    public function render()
    {
        return view('livewire.weather.index', [
            'farms' => Auth::user()->farms()->get(),
            'selectedFarm' => $this->selectedFarmId ? Farm::find($this->selectedFarmId) : null,
        ]);
    }
}
