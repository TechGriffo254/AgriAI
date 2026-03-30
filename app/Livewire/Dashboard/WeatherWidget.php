<?php

namespace App\Livewire\Dashboard;

use App\Models\Farm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WeatherWidget extends Component
{
    public ?array $weather = null;

    public ?Farm $farm = null;

    public bool $loading = true;

    public ?string $error = null;

    public function mount(): void
    {
        $this->farm = Auth::user()->farms()->where('is_active', true)->first();
        if ($this->farm) {
            $this->fetchWeather();
        } else {
            $this->loading = false;
        }
    }

    public function fetchWeather(): void
    {
        if (! $this->farm || ! $this->farm->latitude || ! $this->farm->longitude) {
            $this->loading = false;

            return;
        }

        // Cache weather data for 30 minutes
        $cacheKey = "weather_widget_{$this->farm->id}";

        $this->weather = Cache::remember($cacheKey, 1800, function () {
            try {
                $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $this->farm->latitude,
                    'longitude' => $this->farm->longitude,
                    'current' => 'temperature_2m,weather_code,relative_humidity_2m,wind_speed_10m',
                    'timezone' => 'auto',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $current = $data['current'] ?? [];

                    return [
                        'temperature' => round($current['temperature_2m'] ?? 0),
                        'humidity' => $current['relative_humidity_2m'] ?? 0,
                        'wind_speed' => round($current['wind_speed_10m'] ?? 0),
                        'description' => $this->getWeatherDescription($current['weather_code'] ?? 0),
                        'icon' => $this->getWeatherIcon($current['weather_code'] ?? 0),
                    ];
                }
            } catch (\Exception $e) {
                \Log::warning('Weather widget fetch failed: '.$e->getMessage());
            }

            return null;
        });

        $this->loading = false;
    }

    protected function getWeatherDescription(int $code): string
    {
        return match (true) {
            $code === 0 => 'Clear sky',
            $code === 1 => 'Mainly clear',
            $code === 2 => 'Partly cloudy',
            $code === 3 => 'Overcast',
            in_array($code, [45, 48]) => 'Foggy',
            in_array($code, [51, 53, 55, 56, 57]) => 'Drizzle',
            in_array($code, [61, 63, 65, 66, 67]) => 'Rain',
            in_array($code, [71, 73, 75, 77]) => 'Snow',
            in_array($code, [80, 81, 82]) => 'Showers',
            in_array($code, [85, 86]) => 'Snow showers',
            in_array($code, [95, 96, 99]) => 'Thunderstorm',
            default => 'Unknown',
        };
    }

    protected function getWeatherIcon(int $code): string
    {
        return match (true) {
            $code === 0 => 'sun',
            in_array($code, [1, 2]) => 'cloud-sun',
            $code === 3 => 'cloud',
            in_array($code, [45, 48]) => 'fog',
            in_array($code, [51, 53, 55, 56, 57, 61, 63, 65, 66, 67, 80, 81, 82]) => 'cloud-rain',
            in_array($code, [71, 73, 75, 77, 85, 86]) => 'snowflake',
            in_array($code, [95, 96, 99]) => 'cloud-lightning',
            default => 'sun',
        };
    }

    public function render()
    {
        return view('livewire.dashboard.weather-widget');
    }
}
