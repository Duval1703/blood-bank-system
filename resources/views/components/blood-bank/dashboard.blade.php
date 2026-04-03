<div>
    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Blood Units</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBloodUnits }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Registered Donors</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalDonors }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Critical Alerts</p>
                    <p class="text-2xl font-bold text-red-600">{{ $criticalAlertsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Type Inventory Grid -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Blood Type Inventory</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                @foreach($bloodTypeStock as $bloodType => $stock)
                    <div class="text-center">
                        <div class="mb-2">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-{{ $this->getStockColor($stock['status']) }}-100 text-{{ $this->getStockColor($stock['status']) }}-800 font-bold">
                                {{ $bloodType }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div>Available: {{ $stock['available'] }}</div>
                            <div>Reserved: {{ $stock['reserved'] }}</div>
                            <div>Near Exp: {{ $stock['near_expiry'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Alerts -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Alerts</h2>
            </div>
            <div class="p-6">
                @if($recentAlerts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAlerts as $alert)
                            <div class="flex items-start space-x-3 p-3 bg-{{ $this->getAlertColor($alert->severity) }}-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-{{ $this->getAlertColor($alert->severity) }}-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $alert->message }}</p>
                                    <p class="text-xs text-gray-500">{{ $alert->establishment->name }} • {{ $alert->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">No active alerts</p>
                @endif
            </div>
        </div>

        <!-- Upcoming Expirations -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Upcoming Expirations (Next 7 Days)</h2>
            </div>
            <div class="p-6">
                @if($upcomingExpirations->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingExpirations as $unit)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $unit->unit_number }} ({{ $unit->blood_type }})</p>
                                    <p class="text-xs text-gray-500">{{ $unit->donor->full_name }} • {{ $unit->establishment->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-yellow-800">{{ $unit->expiry_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $unit->days_until_expiry }} days</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">No units expiring soon</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Usage Trends Chart -->
    <div class="bg-white rounded-lg shadow mt-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Usage Trends (Last 30 Days)</h2>
        </div>
        <div class="p-6">
            <div class="h-64">
                @if($usageTrends)
                    <div class="h-full flex items-end justify-between space-x-1">
                        @foreach($usageTrends as $trend)
                            <div class="flex-1 bg-blue-500 hover:bg-blue-600 transition-colors" style="height: {{ ($trend['units_used'] / max(collect($usageTrends)->pluck('units_used')->max(), 1)) * 100 }}%;" title="{{ $trend['date'] }}: {{ $trend['units_used'] }} units">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>