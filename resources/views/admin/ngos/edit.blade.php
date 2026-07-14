<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit NGO / Volunteer') }}
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

                    <form action="{{ route('admin.ngos.update', $ngo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $ngo->first_name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $ngo->last_name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $ngo->email) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $ngo->phone) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="organisation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organisation (Optional)</label>
                                <input type="text" name="organisation" id="organisation" value="{{ old('organisation', $ngo->organisation) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="receiver_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                <select name="receiver_type" id="receiver_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled>Select Type</option>
                                    <option value="ngo" {{ old('receiver_type', $ngo->receiver_type) == 'ngo' ? 'selected' : '' }}>NGO</option>
                                    <option value="volunteer" {{ old('receiver_type', $ngo->receiver_type) == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                    <option value="shelter" {{ old('receiver_type', $ngo->receiver_type) == 'shelter' ? 'selected' : '' }}>Shelter</option>
                                </select>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                <select name="city" id="city" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled>Select City</option>
                                    <option value="Dhaka" {{ old('city', $ngo->city) == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                    <option value="Chittagong" {{ old('city', $ngo->city) == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                    <option value="Rajshahi" {{ old('city', $ngo->city) == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                    <option value="Khulna" {{ old('city', $ngo->city) == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                                    <option value="Barisal" {{ old('city', $ngo->city) == 'Barisal' ? 'selected' : '' }}>Barisal</option>
                                    <option value="Sylhet" {{ old('city', $ngo->city) == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                    <option value="Rangpur" {{ old('city', $ngo->city) == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                                    <option value="Mymensingh" {{ old('city', $ngo->city) == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                </select>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password (Leave blank to keep current)</label>
                                <input type="password" name="password" id="password" minlength="8"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('admin.ngos') }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Record
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
