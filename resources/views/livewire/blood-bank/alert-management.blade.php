<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Alert Management</h1>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <button wire:click="generateLowStockAlerts" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
            Generate Low Stock Alerts
        </button>
        <button wire:click="bulkResolveCriticalAlerts" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Resolve All Critical Alerts
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" wire:model.live="search" placeholder="Search alerts..." class="border rounded px-3 py-2">
            <select wire:model.live="severityFilter" class="border rounded px-3 py-2">
                <option value="">All Severities</option>
                @foreach($severities as $sev)
                    <option value="{{ $sev }}">{{ $sev }}</option>
                @endforeach
            </select>
            <select wire:model.live="bloodTypeFilter" class="border rounded px-3 py-2">
                <option value="">All Blood Types</option>
                @foreach($bloodTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
            <button wire:click="resetFilters" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset Filters
            </button>
        </div>
    </div>

    <!-- Alerts List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse($alerts as $alert)
                <div class="p-6 {{ $alert->is_active ? 'bg-white' : 'bg-gray-50' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="px-2 py-1 text-xs rounded mr-2 bg-{{ $this->getSeverityColor($alert->severity) }}-100 text-{{ $this->getSeverityColor($alert->severity) }}-800">
                                    {{ $alert->severity }}
                                </span>
                                @if($alert->blood_type)
                                    <span class="px-2 py-1 text-xs rounded mr-2 bg-red-100 text-red-800 font-semibold">
                                        {{ $alert->blood_type }}
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500">{{ $alert->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-900 font-medium">{{ $alert->message }}</p>
                            @if($alert->alert_type)
                                <p class="text-sm text-gray-600 mt-1">Type: {{ $alert->alert_type }}</p>
                            @endif
                        </div>
                        <div class="ml-4">
                            @if($alert->is_active)
                                <button wire:click="resolveAlert({{ $alert->id }})" class="text-green-600 hover:text-green-800 text-sm">
                                    Resolve
                                </button>
                            @else
                                <span class="text-green-600 text-sm">✓ Resolved</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">No alerts found</div>
            @endforelse
        </div>
        <div class="px-6 py-4">
            {{ $alerts->links() }}
        </div>
    </div>
</div>
