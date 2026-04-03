<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Donor Management</h1>
            <p class="text-gray-600 mt-1">Register and manage blood donors</p>
        </div>
        <button wire:click="openAddModal" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Register New Donor</span>
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
            <input type="text" wire:model.live="search" placeholder="Search donors..." class="border rounded px-3 py-2">
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

    <!-- Donors Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donor ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Donations</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Eligible</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($donors as $donor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-sm font-semibold text-blue-600">{{ $donor->donor_id_code }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $donor->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold text-red-600">{{ $donor->blood_type }}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $donor->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $donor->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $donor->total_donations }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded bg-{{ $donor->is_eligible ? 'green' : 'red' }}-100 text-{{ $donor->is_eligible ? 'green' : 'red' }}-800">
                                {{ $donor->is_eligible ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="openViewModal({{ $donor->id }})" class="text-blue-600 hover:text-blue-800 mr-2">View</button>
                            <button wire:click="openScreeningModal({{ $donor->id }})" class="text-green-600 hover:text-green-800 mr-2">Screening</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No donors found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $donors->links() }}
        </div>
    </div>

    <!-- Add Donor Modal -->
    @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50 p-4">
            <div class="bg-white rounded-t-xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-y-auto transform transition-transform duration-300 ease-out">
                <div class="px-6 py-5 bg-gradient-to-r from-red-600 to-red-700 border-b border-red-800">
                    <h3 class="text-xl font-bold text-white">Register New Donor</h3>
                </div>
                <form wire:submit.prevent="addDonor" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="col-span-2 border-b pb-4 mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" wire:model="first_name" class="w-full border rounded px-3 py-2" required>
                            @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" wire:model="last_name" class="w-full border rounded px-3 py-2" required>
                            @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                            <input type="date" wire:model="date_of_birth" class="w-full border rounded px-3 py-2" required max="{{ date('Y-m-d') }}">
                            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                            <select wire:model="gender" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" wire:model="weight" class="w-full border rounded px-3 py-2" step="0.01" min="40" max="200">
                            @error('weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-semibold text-gray-900">Contact Information</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" wire:model="phone" class="w-full border rounded px-3 py-2" required>
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" wire:model="address" class="w-full border rounded px-3 py-2" required>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Occupation</label>
                            <input type="text" wire:model="occupation" class="w-full border rounded px-3 py-2">
                            @error('occupation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Medical Information -->
                        <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-semibold text-gray-900">Medical Information</h4>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions</label>
                            <textarea wire:model="medical_conditions" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('medical_conditions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                            <textarea wire:model="current_medications" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('current_medications') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                            <textarea wire:model="allergies" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('allergies') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_eligible" class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4">
                                <span class="ml-2 text-sm text-gray-700">Donor is eligible to donate</span>
                            </label>
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
                            Register Donor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- View Donor Modal -->
    @if($showViewModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50 p-4">
            <div class="bg-white rounded-t-xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto transform transition-transform duration-300 ease-out">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
                    <h3 class="text-xl font-bold text-white">Donor Details - {{ $selectedDonor->full_name }}</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Personal Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Donor ID:</span>
                                    <span class="ml-2 font-mono text-sm font-semibold text-blue-600">{{ $selectedDonor->donor_id_code }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Full Name:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->full_name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Date of Birth:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->date_of_birth->format('M d, Y') }} ({{ $selectedDonor->age }} years)</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Gender:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->gender }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Blood Type:</span>
                                    <span class="ml-2 font-semibold text-red-600">{{ $selectedDonor->blood_type }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Weight:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->weight ? $selectedDonor->weight . ' kg' : 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Occupation:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->occupation ?: 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Contact Information</h4>
                            <div class="grid grid-cols-1 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Phone:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->phone }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Email:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->email }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Address:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->address }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Medical Information</h4>
                            <div class="grid grid-cols-1 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Medical Conditions:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->medical_conditions ?: 'None specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Current Medications:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->current_medications ?: 'None specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Allergies:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->allergies ?: 'None specified' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Donation History -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Donation History</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Total Donations:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->total_donations }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Last Donation:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->last_donation_date ? $selectedDonor->last_donation_date->format('M d, Y') : 'No donations yet' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Eligibility Status:</span>
                                    <span class="ml-2">
                                        <span class="px-2 py-1 text-xs rounded bg-{{ $selectedDonor->is_eligible ? 'green' : 'red' }}-100 text-{{ $selectedDonor->is_eligible ? 'green' : 'red' }}-800">
                                            {{ $selectedDonor->is_eligible ? 'Eligible' : 'Not Eligible' }}
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Next Eligible Date:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->next_eligible_date ? $selectedDonor->next_eligible_date->format('M d, Y') : 'No restrictions' }}</span>
                                </div>
                            </div>
                        </div>

                        @if($selectedDonor->notes)
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Notes</h4>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $selectedDonor->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-between space-x-3 mt-6 pt-6 border-t">
                        <div class="space-x-3">
                            <button type="button" wire:click="openEditModal({{ $selectedDonor->id }})" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Edit Donor
                            </button>
                            <button type="button" wire:click="openScreeningModal({{ $selectedDonor->id }})" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Update Screening
                            </button>
                        </div>
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Donor Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50 p-4">
            <div class="bg-white rounded-t-xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-y-auto transform transition-transform duration-300 ease-out">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
                    <h3 class="text-xl font-bold text-white">Edit Donor - {{ $editingDonor->full_name }}</h3>
                </div>
                <form wire:submit.prevent="updateDonor" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="col-span-2 border-b pb-4 mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" wire:model="first_name" class="w-full border rounded px-3 py-2" required>
                            @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" wire:model="last_name" class="w-full border rounded px-3 py-2" required>
                            @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                            <input type="date" wire:model="date_of_birth" class="w-full border rounded px-3 py-2" required max="{{ date('Y-m-d') }}">
                            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                            <select wire:model="gender" class="w-full border rounded px-3 py-2" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" wire:model="weight" class="w-full border rounded px-3 py-2" step="0.01" min="40" max="200">
                            @error('weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact Information -->
                        <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-semibold text-gray-900">Contact Information</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="tel" wire:model="phone" class="w-full border rounded px-3 py-2" required>
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" wire:model="address" class="w-full border rounded px-3 py-2" required>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Occupation</label>
                            <input type="text" wire:model="occupation" class="w-full border rounded px-3 py-2">
                            @error('occupation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Medical Information -->
                        <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-semibold text-gray-900">Medical Information</h4>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions</label>
                            <textarea wire:model="medical_conditions" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('medical_conditions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                            <textarea wire:model="current_medications" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('current_medications') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                            <textarea wire:model="allergies" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                            @error('allergies') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_eligible" class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4">
                                <span class="ml-2 text-sm text-gray-700">Donor is eligible to donate</span>
                            </label>
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
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update Donor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Blood Screening Modal -->
    @if($showScreeningModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50 p-4">
            <div class="bg-white rounded-t-xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto transform transition-transform duration-300 ease-out">
                <div class="px-6 py-5 bg-gradient-to-r from-green-600 to-green-700 border-b border-green-800">
                    <h3 class="text-xl font-bold text-white">Blood Screening - {{ $selectedDonor->full_name }}</h3>
                </div>
                <form wire:submit.prevent="updateScreening" class="p-6">
                    <div class="space-y-6">
                        <!-- Donor Information Summary -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Donor Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">Name:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->full_name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Current Blood Type:</span>
                                    <span class="ml-2 font-semibold text-red-600">{{ $selectedDonor->blood_type }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Current Eligibility:</span>
                                    <span class="ml-2">
                                        <span class="px-2 py-1 text-xs rounded bg-{{ $selectedDonor->is_eligible ? 'green' : 'red' }}-100 text-{{ $selectedDonor->is_eligible ? 'green' : 'red' }}-800">
                                            {{ $selectedDonor->is_eligible ? 'Eligible' : 'Not Eligible' }}
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Contact:</span>
                                    <span class="ml-2 text-gray-900">{{ $selectedDonor->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Screening Results -->
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Screening Results</h4>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Eligibility Status *</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="screening_eligibility" value="1" class="border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-sm text-gray-700">Eligible for donation</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="screening_eligibility" value="0" class="border-gray-300 text-red-600 focus:ring-red-500">
                                        <span class="ml-2 text-sm text-gray-700">Not eligible for donation</span>
                                    </label>
                                </div>
                                @error('screening_eligibility') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Blood Type *</label>
                                <select wire:model="screening_blood_type" class="w-full border rounded px-3 py-2" required>
                                    <option value="">Select Blood Type</option>
                                    @foreach($bloodTypes as $type)
                                        <option value="{{ $type }}" {{ $selectedDonor->blood_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('screening_blood_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 mt-1">Update if the blood type differs from what was provided during registration</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screening Notes</label>
                                <textarea wire:model="screening_notes" class="w-full border rounded px-3 py-2" rows="4" placeholder="Enter any screening results, observations, or additional notes..."></textarea>
                                @error('screening_notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Update Screening
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
