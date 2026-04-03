<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-600 mt-1">Real-time blood bank statistics and alerts</p>
    </div>

    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium uppercase tracking-wide">Total Blood Units</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalBloodUnits }}</p>
                    <p class="text-red-100 text-xs mt-1">Available for distribution</p>
                </div>
                <div class="bg-opacity bg-opacity-20 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">Total Donors in this Establishment</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalDonors }}</p>
                    <p class="text-emerald-100 text-xs mt-1">Active across all locations</p>
                </div>
                <div class="bg-opacity bg-opacity-20 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium uppercase tracking-wide">Critical Alerts</p>
                    <p class="text-4xl font-bold mt-2">{{ $criticalAlertsCount }}</p>
                    <p class="text-amber-100 text-xs mt-1">Require attention</p>
                </div>
                <div class="bg-opacity bg-opacity-20 p-4 rounded-lg">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Type Inventory Grid -->
    <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-red-600 to-red-700 border-b border-red-800">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Blood Type Inventory
            </h2>
            <p class="text-red-100 text-sm mt-1">Current stock levels by blood type</p>
        </div>
        <div class="p-8 bg-gradient-to-br from-gray-50 to-white">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-6">
                @foreach($bloodTypeStock as $bloodType => $stock)
                    @php
                        $total = $stock['available'] + $stock['reserved'];
                        $statusColor = $total == 0 ? 'red' : ($total <= 5 ? 'amber' : ($total <= 10 ? 'yellow' : 'emerald'));
                    @endphp
                    <div class="group">
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-4 border-2 border-{{ $statusColor }}-200 hover:border-{{ $statusColor }}-400">
                            <div class="text-center mb-3">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-red-600 text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {{ $bloodType }}
                                </div>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-600 font-medium">Available:</span>
                                    <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $stock['available'] }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-600 font-medium">Reserved:</span>
                                    <span class="font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $stock['reserved'] }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-600 font-medium">Near Exp:</span>
                                    <span class="font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">{{ $stock['near_expiry'] }}</span>
                                </div>
                                <div class="pt-2 border-t border-gray-200 mt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-600 font-semibold">Total:</span>
                                        <span class="text-sm font-bold text-{{ $statusColor }}-600">{{ $total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Alerts -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-amber-500 to-amber-600 border-b border-amber-700">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    Recent Alerts
                </h2>
                <p class="text-amber-100 text-sm mt-1">Latest system notifications</p>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                @if($recentAlerts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentAlerts as $alert)
                            @php
                                $severityColors = [
                                    'Critical' => 'red',
                                    'Warning' => 'amber',
                                    'Info' => 'blue',
                                ];
                                $color = $severityColors[$alert->severity] ?? 'gray';
                            @endphp
                            <div class="flex items-start space-x-3 p-4 bg-{{ $color }}-50 border-l-4 border-{{ $color }}-500 rounded-r-lg hover:shadow-md transition-shadow">
                                <div class="flex-shrink-0 mt-0.5">
                                    <div class="w-8 h-8 bg-{{ $color }}-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ $alert->severity }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $alert->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $alert->message }}</p>
                                    @if($alert->blood_type)
                                        <p class="text-xs text-gray-600 mt-1">Blood Type: <span class="font-semibold text-red-600">{{ $alert->blood_type }}</span></p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No active alerts</p>
                        <p class="text-xs text-gray-400">All systems operating normally</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Expirations -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-orange-500 to-orange-600 border-b border-orange-700">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Upcoming Expirations
                </h2>
                <p class="text-orange-100 text-sm mt-1">Units expiring in the next 7 days</p>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                @if($upcomingExpirations->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcomingExpirations as $unit)
                            @php
                                $daysLeft = $unit->days_until_expiry;
                                $urgencyColor = $daysLeft <= 2 ? 'red' : ($daysLeft <= 5 ? 'orange' : 'yellow');
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-{{ $urgencyColor }}-50 border border-{{ $urgencyColor }}-200 rounded-lg hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                        {{ $unit->blood_type }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $unit->unit_number }}</p>
                                        <p class="text-xs text-gray-600">Donor: {{ $unit->donor->full_name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-{{ $urgencyColor }}-100 border border-{{ $urgencyColor }}-300">
                                        <svg class="w-4 h-4 mr-1 text-{{ $urgencyColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-bold text-{{ $urgencyColor }}-800">{{ $daysLeft }} day{{ $daysLeft != 1 ? 's' : '' }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $unit->expiry_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No units expiring soon</p>
                        <p class="text-xs text-gray-400">All inventory is fresh</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
