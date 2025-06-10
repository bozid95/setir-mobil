<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                            Welcome to Driving School Management
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Manage students, finances, sessions, and more from your dashboard.
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Today: {{ now()->format('l, F j, Y') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ now()->format('g:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widgets Grid -->
        <x-filament-widgets::widgets :widgets="$this->getVisibleWidgets()" :columns="$this->getColumns()" />
    </div>
</x-filament-panels::page>
