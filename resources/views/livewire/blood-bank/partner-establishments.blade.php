<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Partner Establishments</h1>
            <p class="text-gray-600 mt-1">View and collaborate with other blood banks</p>
        </div>
        <button wire:click="toggleInventoryVisibility" class="bg-{{ $inventoryVisible ? 'amber' : 'emerald' }}-600 hover:bg-{{ $inventoryVisible ? 'amber' : 'emerald' }}-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($inventoryVisible)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                @endif
            </svg>
            <span>{{ $inventoryVisible ? 'Hide My Inventory' : 'Show My Inventory' }}</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Current Status Card -->
    <div class="bg-{{ $inventoryVisible ? 'blue' : 'gray' }}-50 border border-{{ $inventoryVisible ? 'blue' : 'gray' }}-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-{{ $inventoryVisible ? 'blue' : 'gray' }}-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-semibold text-{{ $inventoryVisible ? 'blue' : 'gray' }}-900">
                    {{ $inventoryVisible ? 'Your inventory is visible to partners' : 'Your inventory is private' }}
                </p>
                <p class="text-sm text-{{ $inventoryVisible ? 'blue' : 'gray' }}-700">
                    {{ $inventoryVisible ? 'Other establishments can view your blood stock levels' : 'Other establishments cannot see your blood stock' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <input type="text" wire:model.live="search" placeholder="Search partner establishments..." class="w-full border rounded px-4 py-2">
    </div>

    <!-- Partner Establishments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($partners as $partner)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $partner->name }}</h3>
                    <p class="text-blue-100 text-sm">{{ $partner->code }}</p>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-gray-700">{{ $partner->type }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $partner->city }}, {{ $partner->state }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $partner->phone }}</span>
                        </div>
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-600">Available Blood Units</p>
                            <p class="text-3xl font-bold text-red-600">{{ $partner->blood_units_count }}</p>
                        </div>
                    </div>
                    <button wire:click="viewPartnerInventory({{ $partner->id }})" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>View Inventory</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p>No partner establishments found</p>
            </div>
        @endforelse
    </div>

    <!-- Partner Inventory Modal -->
    @if($showInventoryModal && $selectedEstablishment)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
                    <h3 class="text-xl font-bold text-white">{{ $selectedEstablishment->name }} - Blood Inventory</h3>
                    <p class="text-blue-100 text-sm">{{ $selectedEstablishment->city }}, {{ $selectedEstablishment->state }}</p>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($partnerInventory as $bloodType => $stock)
                            @php
                                $total = $stock['total'];
                                $statusColor = $total == 0 ? 'red' : ($total <= 5 ? 'amber' : ($total <= 10 ? 'yellow' : 'emerald'));
                            @endphp
                            <div class="text-center">
                                <div class="bg-white rounded-xl shadow-md p-4 border-2 border-{{ $statusColor }}-200 hover:shadow-lg transition-shadow">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-red-600 text-white font-bold text-lg shadow-lg mb-3">
                                        {{ $bloodType }}
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-600">Available:</span>
                                            <span class="font-bold text-emerald-600">{{ $stock['available'] }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-600">Near Expiry:</span>
                                            <span class="font-bold text-amber-600">{{ $stock['near_expiry'] }}</span>
                                        </div>
                                        <div class="pt-2 border-t border-gray-200 mt-2">
                                            <span class="text-xs text-gray-600">Total:</span>
                                            <span class="text-lg font-bold text-{{ $statusColor }}-600 block">{{ $total }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t">
                        <button wire:click="closeModal" class="w-full px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
