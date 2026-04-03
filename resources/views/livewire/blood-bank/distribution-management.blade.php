<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Distribution Management</h1>
            <p class="text-gray-600 mt-1">Reserve and track blood unit distributions</p>
        </div>
        <button wire:click="openAddModal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Reserve Blood Unit</span>
        </button>
    </div>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" wire:model.live="search" placeholder="Search distributions..." class="border rounded px-3 py-2">
            <select wire:model.live="statusFilter" class="border rounded px-3 py-2">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            <select wire:model.live="departmentFilter" class="border rounded px-3 py-2">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Distributions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distribution ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($distributions as $dist)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $dist->distribution_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $dist->bloodUnit->unit_number }} ({{ $dist->bloodUnit->blood_type }})</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $dist->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $dist->patient_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded bg-{{ $this->getStatusColor($dist->status) }}-100 text-{{ $this->getStatusColor($dist->status) }}-800">
                                {{ $dist->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $dist->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="openViewModal({{ $dist->id }})" class="text-blue-600 hover:text-blue-800 mr-2">View</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No distributions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $distributions->links() }}
        </div>
    </div>

    <!-- Reserve Blood Unit Modal -->
    @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-5 bg-gradient-to-r from-red-600 to-red-700 border-b border-red-800">
                    <h3 class="text-xl font-bold text-white">Reserve Blood Unit</h3>
                </div>
                <form wire:submit.prevent="addDistribution" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blood Unit *</label>
                            <select wire:model="blood_unit_id" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Blood Unit</option>
                                @foreach($availableBloodUnits as $unit)
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->unit_number }} - {{ $unit->blood_type }} ({{ $unit->volume }}ml) - Donor: {{ $unit->donor->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood_unit_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                            <select wire:model="department" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                            @error('department') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Purpose *</label>
                            <input type="text" wire:model="purpose" class="w-full border rounded px-3 py-2" required placeholder="e.g., Surgery, Transfusion">
                            @error('purpose') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                            <input type="text" wire:model="patient_name" class="w-full border rounded px-3 py-2">
                            @error('patient_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Patient ID</label>
                            <input type="text" wire:model="patient_id" class="w-full border rounded px-3 py-2">
                            @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reserved Until</label>
                            <input type="datetime-local" wire:model="reserved_until" class="w-full border rounded px-3 py-2">
                            @error('reserved_until') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave blank if no time limit</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Reserve Blood Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
