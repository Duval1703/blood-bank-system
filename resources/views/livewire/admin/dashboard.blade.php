<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">System Administration Dashboard</h1>
        <p class="text-gray-600 mt-1">Manage all blood bank establishments and monitor system-wide statistics</p>
    </div>

    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-opacity bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['total_establishments'] }}</p>
            <p class="text-blue-100 text-sm">Establishments</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-opacity bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
            <p class="text-purple-100 text-sm">Total number of donors in all establishments</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-opacity bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold">{{ $stats['active_alerts'] }}</p>
            <p class="text-amber-100 text-sm">Active Alerts</p>
        </div>
    </div>

    <!-- Establishments Overview -->
    <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Establishments Overview
            </h2>
            <p class="text-blue-100 text-sm mt-1">Active blood bank establishments in the system</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Establishment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donors</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Units</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distributions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($establishments as $establishment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $establishment->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $establishment->code }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $establishment->type }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $establishment->city }}, {{ $establishment->state }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-emerald-600">{{ $establishment->donors_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-red-600">{{ $establishment->blood_units_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-indigo-600">{{ $establishment->distributions_count }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded bg-{{ $establishment->is_active ? 'green' : 'red' }}-100 text-{{ $establishment->is_active ? 'green' : 'red' }}-800">
                                    {{ $establishment->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Establishments -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-purple-600 to-purple-700 border-b border-purple-800">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recently Added Establishments
                </h2>
            </div>
            <div class="p-6">
                @if($recentEstablishments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentEstablishments as $establishment)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $establishment->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $establishment->city }}, {{ $establishment->state }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $establishment->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No establishments yet</p>
                @endif
            </div>
        </div>

        <!-- Critical Alerts -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-amber-600 to-amber-700 border-b border-amber-800">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Critical Alerts
                </h2>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                @if($criticalAlerts->count() > 0)
                    <div class="space-y-3">
                        @foreach($criticalAlerts as $alert)
                            <div class="flex items-start space-x-3 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $alert->message }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $alert->establishment->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $alert->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No critical alerts</p>
                @endif
            </div>
        </div>
    </div>
</div>
