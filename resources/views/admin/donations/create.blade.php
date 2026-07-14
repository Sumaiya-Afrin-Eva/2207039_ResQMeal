<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Donation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.donations.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Food Info -->
                            <div class="md:col-span-2 border-b pb-2 mb-2 dark:border-gray-700">
                                <h3 class="text-lg font-semibold">Food Details</h3>
                            </div>

                            <div>
                                <label for="food_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Food Name *</label>
                                <input type="text" name="food_name" id="food_name" value="{{ old('food_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category *</label>
                                <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select Category</option>
                                    <option value="Cooked" {{ old('category') == 'Cooked' ? 'selected' : '' }}>Cooked</option>
                                    <option value="Raw" {{ old('category') == 'Raw' ? 'selected' : '' }}>Raw/Uncooked</option>
                                    <option value="Packaged" {{ old('category') == 'Packaged' ? 'selected' : '' }}>Packaged/Canned</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity *</label>
                                <input type="number" step="0.01" name="quantity" id="quantity" value="{{ old('quantity') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit *</label>
                                <select name="unit" id="unit" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select Unit</option>
                                    <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                    <option value="liters" {{ old('unit') == 'liters' ? 'selected' : '' }}>Liters</option>
                                    <option value="units" {{ old('unit') == 'units' ? 'selected' : '' }}>Units / Pieces</option>
                                    <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                                </select>
                            </div>

                            <div>
                                <label for="serves" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serves (Number of People) *</label>
                                <input type="number" name="serves" id="serves" value="{{ old('serves') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="expiry" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date & Time *</label>
                                <input type="datetime-local" name="expiry" id="expiry" value="{{ old('expiry') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Pickup Info -->
                            <div class="md:col-span-2 border-b pb-2 mb-2 mt-4 dark:border-gray-700">
                                <h3 class="text-lg font-semibold">Pickup Information</h3>
                            </div>

                            <div>
                                <label for="pickup_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Window Start *</label>
                                <input type="datetime-local" name="pickup_from" id="pickup_from" value="{{ old('pickup_from') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="pickup_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Window End *</label>
                                <input type="datetime-local" name="pickup_to" id="pickup_to" value="{{ old('pickup_to') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label for="pickup_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Address *</label>
                                <input type="text" name="pickup_address" id="pickup_address" value="{{ old('pickup_address') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label for="pickup_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Contact Number *</label>
                                <input type="text" name="pickup_contact" id="pickup_contact" value="{{ old('pickup_contact') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Additional Info -->
                            <div class="md:col-span-2 border-b pb-2 mb-2 mt-4 dark:border-gray-700">
                                <h3 class="text-lg font-semibold">Additional Details</h3>
                            </div>

                            <div>
                                <label for="storage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Storage Instructions</label>
                                <input type="text" name="storage" id="storage" value="{{ old('storage') }}" placeholder="e.g. Keep refrigerated" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="packaging" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Packaging Type</label>
                                <input type="text" name="packaging" id="packaging" value="{{ old('packaging') }}" placeholder="e.g. Plastic boxes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="allergens" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Allergens</label>
                                <input type="text" name="allergens" id="allergens" value="{{ old('allergens') }}" placeholder="e.g. Contains nuts, dairy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label for="dietary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dietary Specifications</label>
                                <input type="text" name="dietary" id="dietary" value="{{ old('dietary') }}" placeholder="e.g. Halal, Vegan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Additional Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Settings & Donor Info -->
                            <div class="md:col-span-2 border-b pb-2 mb-2 mt-4 dark:border-gray-700">
                                <h3 class="text-lg font-semibold">Settings & Donor Info</h3>
                            </div>

                            <div class="md:col-span-2">
                                <label for="donor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Donor ID (Database Link)</label>
                                <input type="number" name="donor_id" id="donor_id" value="{{ old('donor_id') }}" placeholder="Enter ID to link an existing Donor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <p id="donor_status_msg" class="text-sm mt-1 text-gray-500">Type an ID to check database.</p>
                                <input type="hidden" name="donor_name" id="hidden_donor_name" value="{{ old('donor_name') }}">
                            </div>

                            <!-- Register New Donor Section -->
                            <div id="new_donor_section" class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="text-md font-semibold mb-3">Register New Donor</h4>
                                <p class="text-sm text-gray-500 mb-4">If the donor does not exist above, fill out this information to register them automatically.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="organisation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organisation (Optional)</label>
                                        <input type="text" name="organisation" id="organisation" value="{{ old('organisation') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="donor_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Donor Type</label>
                                        <select name="donor_type" id="donor_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="individual" {{ old('donor_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                            <option value="restaurant" {{ old('donor_type') == 'restaurant' ? 'selected' : '' }}>Restaurant/Hotel</option>
                                            <option value="event" {{ old('donor_type') == 'event' ? 'selected' : '' }}>Event Organizer</option>
                                            <option value="other" {{ old('donor_type') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Password</label>
                                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visibility *</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="visibility" id="visibility_1" value="1" {{ old('visibility', '1') == '1' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="visibility_1" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Visible to Public</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="visibility" id="visibility_0" value="0" {{ old('visibility') == '0' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="visibility_0" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Hidden / Draft</label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Emergency Status *</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="emergency" id="emergency_1" value="1" {{ old('emergency') == '1' ? 'checked' : '' }} class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                        <label for="emergency_1" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Emergency (Needs immediate pickup)</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="emergency" id="emergency_0" value="0" {{ old('emergency', '0') == '0' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="emergency_0" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Normal</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.donations') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Save Donation</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const donorIdInput = document.getElementById('donor_id');
    const msgBox = document.getElementById('donor_status_msg');
    
    // Elements to require/unrequire based on donor ID
    const newDonorSection = document.getElementById('new_donor_section');
    const requiredDonorFields = ['first_name', 'last_name', 'email', 'phone', 'city', 'password'];

    function toggleNewDonorRequirements(isRequired) {
        requiredDonorFields.forEach(fieldId => {
            const el = document.getElementById(fieldId);
            if(el) el.required = isRequired;
        });
    }

    donorIdInput.addEventListener('input', function() {
        const id = this.value;
        const hiddenNameInput = document.getElementById('hidden_donor_name');
        if(id === '') {
            msgBox.textContent = 'For existing donor you can add id, else register new donor.';
            msgBox.className = 'text-sm mt-1 text-gray-500';
            hiddenNameInput.value = '';
            toggleNewDonorRequirements(true);
            return;
        }

        fetch(`/admin/donations/check-donor/${id}`)
            .then(response => response.json())
            .then(data => {
                if(data.exists) {
                    msgBox.innerHTML = '<span class="text-green-600 font-medium">✓ Found Donor: ' + data.name + '</span>';
                    hiddenNameInput.value = data.name;
                    toggleNewDonorRequirements(false);
                } else {
                    msgBox.innerHTML = '<span class="text-red-600 font-medium">⚠ Donor not found. For existing donor you can add correct id, else register new donor below.</span>';
                    hiddenNameInput.value = '';
                    toggleNewDonorRequirements(true);
                }
            })
            .catch(error => {
                msgBox.textContent = 'Error checking donor.';
                hiddenNameInput.value = '';
            });
    });

    // Run on load in case there's old input
    if(donorIdInput.value === '') {
        msgBox.textContent = 'For existing donor you can add id, else register new donor.';
        toggleNewDonorRequirements(true);
    } else {
        donorIdInput.dispatchEvent(new Event('input'));
    }
});
</script>
