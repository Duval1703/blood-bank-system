<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Blood Inventory Management</h1>
            <p class="text-gray-600 mt-1">Manage blood units and track inventory</p>
        </div>
        <button wire:click="openAddModal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add Blood Unit</span>
        </button>
    </div>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" wire:model.live="search" placeholder="Search..." class="border rounded px-3 py-2">
            <select wire:model.live="bloodTypeFilter" class="border rounded px-3 py-2">
                <option value="">All Blood Types</option>
                @foreach($bloodTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
            <select wire:model.live="statusFilter" class="border rounded px-3 py-2">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            <button wire:click="resetFilters" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset Filters
            </button>
        </div>
    </div>

    <!-- Blood Units Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Collection Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bloodUnits as $unit)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $unit->unit_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold text-red-600">{{ $unit->blood_type }}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $unit->donor->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $unit->collection_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $unit->expiry_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded bg-{{ $this->getStatusColor($unit->status) }}-100 text-{{ $this->getStatusColor($unit->status) }}-800">
                                {{ $unit->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="openViewModal({{ $unit->id }})" class="text-blue-600 hover:text-blue-800 mr-2">View</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No blood units found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $bloodUnits->links() }}
        </div>
    </div>

    <!-- Add Blood Unit Modal -->
    @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-5 bg-gradient-to-r from-red-600 to-red-700 border-b border-red-800">
                    <h3 class="text-xl font-bold text-white">Add New Blood Unit</h3>
                </div>
                <form wire:submit.prevent="addBloodUnit" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit Number (Auto-generated)</label>
                            <input type="text" wire:model="unit_number" class="w-full border rounded px-3 py-2 bg-gray-100" readonly placeholder="BU2026000001">
                            <p class="text-xs text-gray-500 mt-1">Unit number is automatically assigned</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blood Type *</label>
                            <select wire:model="blood_type" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Blood Type</option>
                                @foreach($bloodTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('blood_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Donor Selection *</label>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Enter Donor ID Code:</label>
                                    <div class="flex space-x-2">
                                        <input type="text" wire:model="donor_id_code" class="flex-1 border rounded px-3 py-2" placeholder="e.g., DON-123456">
                                        <button type="button" wire:click="lookupDonorByCode" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                            Lookup
                                        </button>
                                    </div>
                                    @error('donor_id_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                @if($selectedDonor)
                                    <div class="bg-green-50 border border-green-200 rounded p-3">
                                        <p class="text-sm text-green-800">
                                            <strong>Selected:</strong> {{ $selectedDonor->full_name }} ({{ $selectedDonor->donor_id_code }}) - {{ $selectedDonor->blood_type }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Or select from list:</label>
                                    <select wire:model="donor_id" class="w-full border rounded px-3 py-2">
                                        <option value="">Select Donor</option>
                                        @foreach($donors as $donor)
                                            <option value="{{ $donor->id }}">{{ $donor->full_name }} ({{ $donor->blood_type }})</option>
                                        @endforeach
                                    </select>
                                    @error('donor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Volume (ml) *</label>
                            <input type="number" wire:model="volume" class="w-full border rounded px-3 py-2" required min="200" max="600">
                            @error('volume') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Collection Date *</label>
                            <input type="date" wire:model="collection_date" class="w-full border rounded px-3 py-2" required max="{{ date('Y-m-d') }}">
                            @error('collection_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                            <input type="date" wire:model="expiry_date" class="w-full border rounded px-3 py-2" required>
                            @error('expiry_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea wire:model="notes" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Add Blood Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
