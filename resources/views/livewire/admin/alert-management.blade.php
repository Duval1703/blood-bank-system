<div>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">View Alerts</h1>
            <p class="text-gray-600 mt-2">Monitor system alerts across all establishments</p>
        </div>

        <!-- Alert Statistics -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">System Alert Statistics</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Total Active:</span>
                        <span class="text-2xl font-bold text-gray-900">{{ $alerts->where('is_active', true)->count() }}</span>
                    </div>
                </div>
                <div class="bg-red-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-red-600">Critical:</span>
                        <span class="text-2xl font-bold text-red-600">{{ $alerts->where('severity', 'Critical')->count() }}</span>
                    </div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-yellow-600">Warning:</span>
                        <span class="text-2xl font-bold text-yellow-600">{{ $alerts->where('severity', 'Warning')->count() }}</span>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-600">Info:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $alerts->where('severity', 'Info')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Alerts -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent System Alerts</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Establishment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($alerts as $alert)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $alert->establishment->name ?? 'System' }}</td>
                                <td class="px-6 py-4">{{ $alert->message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($alert->severity === 'Critical') bg-red-100 text-red-800
                                        @elseif($alert->severity === 'Warning') bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ $alert->severity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $alert->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($alert->is_active) bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $alert->is_active ? 'Active' : 'Resolved' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No alerts found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
