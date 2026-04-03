<div>
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Establishment Management</h1>
            <p class="text-gray-600 mt-1">Create and manage blood bank establishments</p>
        </div>
        <button wire:click="openAddModal" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add New Establishment</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <input type="text" wire:model.live="search" placeholder="Search establishments..." class="w-full border rounded px-4 py-2">
    </div>

    <!-- Establishments Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Establishment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stats</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($establishments as $establishment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-bold text-gray-900">{{ $establishment->name }}</p>
                                <p class="text-sm text-gray-500">Code: {{ $establishment->code }}</p>
                                <p class="text-xs text-gray-500">{{ $establishment->city }}, {{ $establishment->state }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $establishment->type }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $establishment->phone }}</p>
                            <p class="text-xs text-gray-500">{{ $establishment->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4 text-sm">
                                <span class="text-emerald-600 font-medium">{{ $establishment->donors_count }} donors</span>
                                <span class="text-red-600 font-medium">{{ $establishment->blood_units_count }} units</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleStatus({{ $establishment->id }})" class="px-3 py-1 text-xs rounded transition-colors {{ $establishment->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                {{ $establishment->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="deleteEstablishment({{ $establishment->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800 text-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No establishments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50">
            {{ $establishments->links() }}
        </div>
    </div>

    <!-- Add Establishment Modal -->
    @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
                    <h3 class="text-xl font-bold text-white">Add New Establishment</h3>
                </div>
                <form wire:submit.prevent="addEstablishment" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Establishment Details -->
                        <div class="col-span-2 border-b pb-4 mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Establishment Information</h4>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2" required>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Code *</label>
                            <input type="text" wire:model="code" class="w-full border rounded px-3 py-2" required>
                            @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                            <select wire:model="type" class="w-full border rounded px-3 py-2" required>
                                <option value="Blood Bank">Blood Bank</option>
                                <option value="Hospital">Hospital</option>
                                <option value="Clinic">Clinic</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                            <input type="text" wire:model="contact_person" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" wire:model="address" class="w-full border rounded px-3 py-2" required>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" wire:model="city" class="w-full border rounded px-3 py-2" required>
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                            <input type="text" wire:model="state" class="w-full border rounded px-3 py-2" required>
                            @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code *</label>
                            <input type="text" wire:model="zip_code" class="w-full border rounded px-3 py-2" required>
                            @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                            <input type="text" wire:model="phone" class="w-full border rounded px-3 py-2" required>
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Manager Account -->
                        <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Manager Account Credentials</h4>
                            <p class="text-sm text-gray-600">Create login credentials for the establishment manager</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manager Name *</label>
                            <input type="text" wire:model="manager_name" class="w-full border rounded px-3 py-2" required>
                            @error('manager_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manager Email *</label>
                            <input type="email" wire:model="manager_email" class="w-full border rounded px-3 py-2" required>
                            @error('manager_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manager Password *</label>
                            <input type="password" wire:model="manager_password" class="w-full border rounded px-3 py-2" required>
                            @error('manager_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Establishment & Manager Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
