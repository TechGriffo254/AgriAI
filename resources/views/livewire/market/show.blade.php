<div>
    <x-theme.agri-page-header
        title="{{ $marketPrice->commodity }}"
        :description="$marketPrice->variety ? $marketPrice->variety . ' - ' . $marketPrice->market_name : $marketPrice->market_name"
    >
        <x-slot:actions>
            <x-theme.agri-button :href="route('market.edit', $marketPrice)" variant="secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </x-theme.agri-button>
            <x-theme.agri-button :href="route('market.index')" variant="secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <!-- Price Overview Cards -->
    <div class="grid gap-4 md:grid-cols-4 mb-6">
        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-lime-100 dark:bg-lime-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-lime-600 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Current Price</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">KES {{ number_format($marketPrice->price, 0) }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">per {{ $marketPrice->unit }}</p>
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Average Price</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">KES {{ number_format($avgPrice, 0) }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $priceCount }} records</p>
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Price Range</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ number_format($minPrice, 0) }} - {{ number_format($maxPrice, 0) }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Min - Max</p>
                </div>
            </div>
        </x-theme.agri-card>

        <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center gap-3">
                @php $changePositive = ($marketPrice->price_change_percent ?? 0) >= 0; @endphp
                <div class="w-12 h-12 {{ $changePositive ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $changePositive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($changePositive)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        @endif
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Change</p>
                    <p class="text-xl font-bold {{ $changePositive ? 'text-green-600' : 'text-red-600' }}">
                        {{ $changePositive ? '+' : '' }}{{ number_format($marketPrice->price_change_percent ?? 0, 1) }}%
                    </p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">From previous</p>
                </div>
            </div>
        </x-theme.agri-card>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left Column: Chart & Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Price Chart -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white">Price Trend</h3>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Last 30 entries</span>
                </div>

                @if(count($chartData) > 1)
                    <div
                        x-data="{
                            chartData: {{ json_encode($chartData) }},
                            init() {
                                this.drawChart();
                            },
                            drawChart() {
                                const canvas = this.$refs.chart;
                                const ctx = canvas.getContext('2d');
                                const data = this.chartData;
                                const padding = 40;
                                const width = canvas.width - padding * 2;
                                const height = canvas.height - padding * 2;

                                // Clear canvas
                                ctx.clearRect(0, 0, canvas.width, canvas.height);

                                // Get min/max values
                                const prices = data.map(d => d.price);
                                const minPrice = Math.min(...prices) * 0.95;
                                const maxPrice = Math.max(...prices) * 1.05;
                                const priceRange = maxPrice - minPrice;

                                // Draw grid lines
                                ctx.strokeStyle = '#e5e7eb';
                                ctx.lineWidth = 1;
                                for (let i = 0; i <= 4; i++) {
                                    const y = padding + (height / 4) * i;
                                    ctx.beginPath();
                                    ctx.moveTo(padding, y);
                                    ctx.lineTo(padding + width, y);
                                    ctx.stroke();

                                    // Price labels
                                    const priceLabel = Math.round(maxPrice - (priceRange / 4) * i);
                                    ctx.fillStyle = '#9ca3af';
                                    ctx.font = '10px sans-serif';
                                    ctx.textAlign = 'right';
                                    ctx.fillText(priceLabel.toLocaleString(), padding - 5, y + 3);
                                }

                                // Draw line chart
                                ctx.beginPath();
                                ctx.strokeStyle = '#84cc16';
                                ctx.lineWidth = 2;

                                data.forEach((point, index) => {
                                    const x = padding + (width / (data.length - 1)) * index;
                                    const y = padding + height - ((point.price - minPrice) / priceRange) * height;

                                    if (index === 0) {
                                        ctx.moveTo(x, y);
                                    } else {
                                        ctx.lineTo(x, y);
                                    }
                                });
                                ctx.stroke();

                                // Draw points
                                data.forEach((point, index) => {
                                    const x = padding + (width / (data.length - 1)) * index;
                                    const y = padding + height - ((point.price - minPrice) / priceRange) * height;

                                    ctx.beginPath();
                                    ctx.arc(x, y, 4, 0, Math.PI * 2);
                                    ctx.fillStyle = '#84cc16';
                                    ctx.fill();
                                    ctx.strokeStyle = '#fff';
                                    ctx.lineWidth = 2;
                                    ctx.stroke();
                                });

                                // Draw date labels
                                ctx.fillStyle = '#9ca3af';
                                ctx.font = '10px sans-serif';
                                ctx.textAlign = 'center';
                                const labelStep = Math.ceil(data.length / 6);
                                data.forEach((point, index) => {
                                    if (index % labelStep === 0 || index === data.length - 1) {
                                        const x = padding + (width / (data.length - 1)) * index;
                                        ctx.fillText(point.date, x, canvas.height - 10);
                                    }
                                });
                            }
                        }"
                        class="w-full"
                    >
                        <canvas x-ref="chart" width="600" height="250" class="w-full"></canvas>
                    </div>
                @else
                    <div class="flex items-center justify-center h-48 text-zinc-400 dark:text-zinc-500">
                        <p>Not enough data to display chart</p>
                    </div>
                @endif
            </x-theme.agri-card>

            <!-- Price Details -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">Price Details</h3>
                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Commodity</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->commodity }}</dd>
                    </div>
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Variety</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->variety ?: 'N/A' }}</dd>
                    </div>
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Market</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->market_name }}</dd>
                    </div>
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Location</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->location ?: 'N/A' }}</dd>
                    </div>
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Price Date</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->price_date->format('F j, Y') }}</dd>
                    </div>
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Quality Grade</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->quality_grade ?: 'N/A' }}</dd>
                    </div>
                    @if($marketPrice->price_min && $marketPrice->price_max)
                        <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                            <dt class="text-sm text-zinc-500 dark:text-zinc-400">Price Range</dt>
                            <dd class="mt-1 text-zinc-800 dark:text-white font-medium">
                                KES {{ number_format($marketPrice->price_min, 0) }} - {{ number_format($marketPrice->price_max, 0) }}
                            </dd>
                        </div>
                    @endif
                    <div class="bg-agri-bg dark:bg-zinc-800 rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400">Data Source</dt>
                        <dd class="mt-1 text-zinc-800 dark:text-white font-medium">{{ $marketPrice->data_source ?: 'Manual Entry' }}</dd>
                    </div>
                </dl>
            </x-theme.agri-card>

            <!-- Price History Table -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 p-0 overflow-hidden">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white">Price History</h3>
                </div>
                @if($priceHistory->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-agri-bg dark:bg-zinc-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Price</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Range</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Change</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($priceHistory->reverse() as $history)
                                    <tr wire:key="history-{{ $history->id }}" class="hover:bg-agri-bg/50 dark:hover:bg-zinc-800/50">
                                        <td class="px-6 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $history->price_date->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-zinc-800 dark:text-white">
                                            KES {{ number_format($history->price, 0) }}/{{ $history->unit }}
                                        </td>
                                        <td class="px-6 py-3 text-center text-xs text-zinc-500 dark:text-zinc-400">
                                            @if($history->price_min && $history->price_max)
                                                {{ number_format($history->price_min, 0) }} - {{ number_format($history->price_max, 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm">
                                            @if($history->price_change_percent)
                                                <span class="{{ $history->price_change_percent >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $history->price_change_percent >= 0 ? '+' : '' }}{{ number_format($history->price_change_percent, 1) }}%
                                                </span>
                                            @else
                                                <span class="text-zinc-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">
                        No historical data available
                    </div>
                @endif
            </x-theme.agri-card>
        </div>

        <!-- Right Column: Other Markets & Actions -->
        <div class="space-y-6">
            <!-- Other Markets -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">Other Markets</h3>
                @if($otherMarkets->count() > 0)
                    <div class="space-y-3">
                        @foreach($otherMarkets as $other)
                            <a href="{{ route('market.show', $other) }}" wire:navigate class="block p-3 bg-agri-bg dark:bg-zinc-800 rounded-xl hover:ring-2 hover:ring-agri-lime transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">{{ $other->market_name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $other->location }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-zinc-800 dark:text-white">KES {{ number_format($other->price, 0) }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $other->price_date->format('M j') }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">
                        No other markets found for this commodity
                    </p>
                @endif
            </x-theme.agri-card>

            <!-- AI Predictions -->
            @if($marketPrice->predicted_price_7d || $marketPrice->predicted_price_30d)
                <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">AI Predictions</h3>
                    <div class="space-y-4">
                        @if($marketPrice->predicted_price_7d)
                            <div class="flex items-center justify-between p-3 bg-agri-bg dark:bg-zinc-800 rounded-xl">
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">7-Day Forecast</span>
                                <span class="font-medium text-zinc-800 dark:text-white">KES {{ number_format($marketPrice->predicted_price_7d, 0) }}</span>
                            </div>
                        @endif
                        @if($marketPrice->predicted_price_30d)
                            <div class="flex items-center justify-between p-3 bg-agri-bg dark:bg-zinc-800 rounded-xl">
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">30-Day Forecast</span>
                                <span class="font-medium text-zinc-800 dark:text-white">KES {{ number_format($marketPrice->predicted_price_30d, 0) }}</span>
                            </div>
                        @endif
                    </div>
                    @if($marketPrice->ai_analyzed_at)
                        <p class="mt-4 text-xs text-zinc-400 dark:text-zinc-500">
                            Last analyzed: {{ $marketPrice->ai_analyzed_at->diffForHumans() }}
                        </p>
                    @endif
                </x-theme.agri-card>
            @endif

            <!-- Actions -->
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">Actions</h3>
                <div class="space-y-3">
                    <x-theme.agri-button :href="route('market.edit', $marketPrice)" variant="secondary" class="w-full justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Price
                    </x-theme.agri-button>
                    <button
                        wire:click="delete"
                        wire:confirm="Are you sure you want to delete this price entry?"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Price
                    </button>
                </div>
            </x-theme.agri-card>
        </div>
    </div>
</div>
