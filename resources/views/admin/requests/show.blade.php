<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Food Request Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('admin.requests') }}" class="text-blue-600 hover:underline dark:text-blue-400">&larr; Back to Requests</a>
            </div>

            <!-- Request Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2 dark:border-gray-700">Request Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Requester Name</p>
                            <p class="font-medium">{{ $request->requester_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Requested On</p>
                            <p class="font-medium">{{ $request->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium">{{ $request->requester_email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="font-medium">{{ $request->requester_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Organisation</p>
                            <p class="font-medium">{{ $request->organisation ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Receiver Type</p>
                            <p class="font-medium capitalize">{{ str_replace('_', ' ', $request->receiver_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Requested Quantity</p>
                            <p class="font-medium">{{ $request->requested_quantity }} {{ $request->quantity_unit }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Beneficiary Count</p>
                            <p class="font-medium">{{ $request->beneficiary_count }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">City</p>
                            <p class="font-medium">{{ $request->requester_city }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Delivery Address</p>
                            <p class="font-medium">{{ $request->delivery_address ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Preferred Pickup</p>
                            <p class="font-medium">{{ $request->preferred_pickup_from ?? 'N/A' }} - {{ $request->preferred_pickup_to ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Transport Method</p>
                            <p class="font-medium capitalize">{{ $request->transport ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Purpose</p>
                            <p class="font-medium">{{ $request->purpose ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Additional Notes</p>
                            <p class="font-medium">{{ $request->notes ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connected Donation & Donor Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2 dark:border-gray-700">Donation & Donor Information</h3>
                    
                    @if($request->donation)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donation ID</p>
                                <p class="font-medium">#{{ $request->donation->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donated Food</p>
                                <p class="font-medium">{{ $request->donation->food_name }} ({{ $request->donation->category }})</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Quantity Given by Donor</p>
                                <p class="font-medium">{{ $request->donation->quantity }} {{ $request->donation->unit }} (Serves: {{ $request->donation->serves }})</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor Pickup Location</p>
                                <p class="font-medium">{{ $request->donation->pickup_address ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor Pickup Window</p>
                                <p class="font-medium">{{ $request->donation->pickup_from }} - {{ $request->donation->pickup_to }}</p>
                            </div>
                            
                            <div class="md:col-span-2 mt-2 pt-2 border-t dark:border-gray-700"></div>
                            
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor Name</p>
                                <p class="font-medium">
                                    @if($request->donation->donor)
                                        {{ $request->donation->donor->first_name }} {{ $request->donation->donor->last_name }}
                                    @else
                                        {{ $request->donation->donor_name ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor ID</p>
                                <p class="font-medium">
                                    @if($request->donation->donor)
                                        #{{ $request->donation->donor->id }}
                                    @else
                                        Guest/Unregistered
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor Email</p>
                                <p class="font-medium">
                                    @if($request->donation->donor)
                                        {{ $request->donation->donor->email }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Donor Phone</p>
                                <p class="font-medium">
                                    @if($request->donation->donor)
                                        {{ $request->donation->donor->phone }}
                                    @else
                                        {{ $request->donation->pickup_contact ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-red-50 text-red-700 rounded-md dark:bg-red-900/50 dark:text-red-400">
                            The associated donation for this request has been deleted or is no longer available.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
