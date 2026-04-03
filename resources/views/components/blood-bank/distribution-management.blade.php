<div>
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Distributions & Reservations</h1>
                <button wire:click="openAddModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    New Distribution
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" wire:model.live="search" placeholder="Patient, purpose, or unit number" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select wire:model.live="departmentFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Establishment</label>
                    <select wire:model.live="establishmentFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Establishments</option>
                        @foreach($establishments as $establishment)
                            <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" wire:model.live="dateFilter" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="mt-4">
                <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Distributions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distribution ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blood Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($distributions as $distribution)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $distribution->distribution_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $distribution->bloodUnit->unit_number }}</div>
                                <div class="text-sm text-gray-500">{{ $distribution->bloodUnit->blood_type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $distribution->patient_name }}</div>
                                <div class="text-sm text-gray-500">{{ $distribution->patient_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $distribution->department }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $distribution->purpose }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $this->getStatusColor($distribution->status) }}-100 text-{{ $this->getStatusColor($distribution->status) }}-800">
                                    {{ $distribution->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $distribution->created_at->format('M d, Y') }}
                                @if($distribution->reserved_until && $distribution->status === 'Reserved')
                                    <div class="text-xs text-yellow-600">Reserved until {{ $distribution->reserved_until->format('M d H:i') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button wire:click="openViewModal({{ $distribution->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                                    @if($distribution->status === 'Reserved')
                                        <button wire:click="issueDistribution({{ $distribution->id }})" class="text-green-600 hover:text-green-900">Issue</button>
                                        <button wire:click="cancelDistribution({{ $distribution->id }})" class="text-yellow-600 hover:text-yellow-900">Cancel</button>
                                    @endif
                                    <button wire:click="openEditModal({{ $distribution->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button wire:click="deleteDistribution({{ $distribution->id }})" 
                                            wire:confirm="Are you sure you want to delete this distribution?" 
                                            class="text-red-600 hover:text-red-900">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No distributions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button wire:click="previousPage">Previous</button>
                <button wire:click="nextPage">Next</button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $distributions->firstItem() }}</span> to 
                        <span class="font-medium">{{ $distributions->lastItem() }}</span> of 
                        <span class="font-medium">{{ $distributions->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $distributions->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showAddModal || $showEditModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $showAddModal ? 'New Distribution' : 'Edit Distribution' }}
                    </h3>
                    
                    <form wire:submit="{{ $showAddModal ? 'addDistribution' : 'updateDistribution' }}" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Blood Unit</label>
                                <select wire:model="blood_unit_id" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Blood Unit</option>
                                    @foreach($availableBloodUnits as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_number }} ({{ $unit->blood_type }}) - {{ $unit->donor->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('blood_unit_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Requesting Establishment</label>
                                <select wire:model="requesting_establishment_id" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Establishment</option>
                                    @foreach($establishments as $establishment)
                                        <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                                    @endforeach
                                </select>
                                @error('requesting_establishment_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Recipient Name</label>
                                <input type="text" wire:model="recipient_name" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('recipient_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Recipient Type</label>
                                <select wire:model="recipient_type" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    @foreach($recipientTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('recipient_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Urgency Level</label>
                                <select wire:model="urgency_level" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Urgency</option>
                                    @foreach($urgencyLevels as $level)
                                        <option value="{{ $level }}">{{ $level }}</option>
                                    @endforeach
                                </select>
                                @error('urgency_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Distribution Type</label>
                                <select wire:model="distribution_type" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Reservation">Reservation</option>
                                    <option value="Direct Issue">Direct Issue</option>
                                </select>
                                @error('distribution_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Purpose</label>
                                <input type="text" wire:model="purpose" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('purpose') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            @if($distribution_type === 'Reservation')
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Expected Return Date</label>
                                    <input type="date" wire:model="expected_return_date"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('expected_return_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea wire:model="notes" rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ $showAddModal ? 'Create Distribution' : 'Update Distribution' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Modal -->
    @if($showViewModal && $selectedDistribution)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Distribution Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Blood Unit Information</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Unit Number:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->bloodUnit->unit_number }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Blood Type:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->bloodUnit->blood_type }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Donor:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->bloodUnit->donor->full_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Volume:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->bloodUnit->volume }}ml</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Recipient Information</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Name:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->recipient_name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Type:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->recipient_type }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Requesting Establishment:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->requestingEstablishment->name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Purpose:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->purpose }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Distribution Information</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Type:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->distribution_type }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Urgency Level:</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $this->getUrgencyColor($selectedDistribution->urgency_level) }}-100 text-{{ $this->getUrgencyColor($selectedDistribution->urgency_level) }}-800">
                                            {{ $selectedDistribution->urgency_level }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $this->getStatusColor($selectedDistribution->status) }}-100 text-{{ $this->getStatusColor($selectedDistribution->status) }}-800">
                                            {{ $selectedDistribution->status }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Created By:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->createdBy->name }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Dates</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Created Date:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Issued Date:</dt>
                                    <dd class="text-sm text-gray-900">{{ $selectedDistribution->issued_at ? $selectedDistribution->issued_at->format('M d, Y H:i') : 'Not issued' }}</dd>
                                </div>
                                @if($selectedDistribution->expected_return_date)
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Expected Return:</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedDistribution->expected_return_date->format('M d, Y') }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                    
                    @if($selectedDistribution->notes)
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-900 mb-2">Notes</h4>
                            <p class="text-sm text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $selectedDistribution->notes }}</p>
                        </div>
                    @endif
                    
                    <div class="flex justify-end mt-6">
                        <button wire:click="closeModal" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if(session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
            {{ session('message') }}
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50">
            {{ session('error') }}
        </div>
    @endif
</div>