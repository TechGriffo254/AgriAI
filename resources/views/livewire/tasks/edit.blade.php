<div>
    <x-theme.agri-page-header
        title="Edit Task"
        description="Update task details"
        :back-href="route('tasks.show', $task)"
        back-label="Back to Task"
    />

    <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="save" class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Task Title <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    placeholder="e.g., Water tomato seedlings"
                    class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Description
                </label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="3"
                    placeholder="Add any additional details..."
                    class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent resize-none"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Farm -->
                <div>
                    <label for="farm_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Farm
                    </label>
                    <select
                        id="farm_id"
                        wire:model.live="farm_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="">Select a farm (optional)</option>
                        @foreach($farms as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('farm_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Crop Cycle -->
                <div>
                    <label for="crop_cycle_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Crop Cycle
                    </label>
                    <select
                        id="crop_cycle_id"
                        wire:model="crop_cycle_id"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        {{ !$farm_id ? 'disabled' : '' }}
                    >
                        <option value="">Select a crop cycle (optional)</option>
                        @foreach($cropCycles as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @if(!$farm_id)
                        <p class="mt-1 text-xs text-zinc-500">Select a farm first to see crop cycles</p>
                    @endif
                    @error('crop_cycle_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        wire:model="category"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="planting">🌱 Planting</option>
                        <option value="watering">💧 Watering</option>
                        <option value="fertilizing">🧪 Fertilizing</option>
                        <option value="harvesting">🌾 Harvesting</option>
                        <option value="pest_control">🐛 Pest Control</option>
                        <option value="maintenance">🔧 Maintenance</option>
                        <option value="other">📋 Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Priority <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="priority"
                        wire:model="priority"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="low">🟢 Low</option>
                        <option value="medium">🟡 Medium</option>
                        <option value="high">🟠 High</option>
                        <option value="urgent">🔴 Urgent</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="status"
                        wire:model="status"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                        <option value="pending">⏳ Pending</option>
                        <option value="in_progress">🔄 In Progress</option>
                        <option value="completed">✅ Completed</option>
                        <option value="cancelled">❌ Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Due Date
                    </label>
                    <input
                        type="date"
                        id="due_date"
                        wire:model="due_date"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Time -->
                <div>
                    <label for="due_time" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Due Time
                    </label>
                    <input
                        type="time"
                        id="due_time"
                        wire:model="due_time"
                        class="w-full px-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                    >
                    @error('due_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Reminder Settings -->
            <div class="p-4 bg-agri-bg dark:bg-zinc-900 rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-sm font-medium text-zinc-800 dark:text-white">Enable Reminder</h4>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Get notified before the task is due</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="reminder_enabled" class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-agri-lime rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-agri-lime"></div>
                    </label>
                </div>

                @if($reminder_enabled)
                    <div>
                        <label for="reminder_minutes_before" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Remind me
                        </label>
                        <select
                            id="reminder_minutes_before"
                            wire:model="reminder_minutes_before"
                            class="w-full px-4 py-2.5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-agri-lime focus:border-transparent"
                        >
                            <option value="15">15 minutes before</option>
                            <option value="30">30 minutes before</option>
                            <option value="60">1 hour before</option>
                            <option value="120">2 hours before</option>
                            <option value="1440">1 day before</option>
                        </select>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    type="button"
                    wire:click="delete"
                    wire:confirm="Are you sure you want to delete this task?"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Task
                </button>

                <div class="flex items-center gap-3">
                    <x-theme.agri-button :href="route('tasks.show', $task)" variant="ghost">
                        Cancel
                    </x-theme.agri-button>
                    <x-theme.agri-button type="submit" variant="primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </x-theme.agri-button>
                </div>
            </div>
        </form>
    </x-theme.agri-card>
</div>
