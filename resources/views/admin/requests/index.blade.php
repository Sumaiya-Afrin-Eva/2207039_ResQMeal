<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Food Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All Food Requests</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Requested Item</th>
                                    <th scope="col" class="px-6 py-3">Requester Name</th>
                                    <th scope="col" class="px-6 py-3">Requested Quantity</th>
                                    <th scope="col" class="px-6 py-3">Beneficiaries</th>
                                    <th scope="col" class="px-6 py-3">Priority</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            @if($request->donation)
                                                {{ $request->donation->food_name }}
                                            @else
                                                <span class="text-gray-400 italic">Donation deleted</span>
                                            @endif
                                        </td>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $request->requester_name }}
                                        </th>
                                        <td class="px-6 py-4">{{ $request->requested_quantity }} {{ $request->quantity_unit }}</td>
                                        <td class="px-6 py-4">{{ $request->beneficiary_count }}</td>
                                        <td class="px-6 py-4 capitalize">
                                            @if($request->priority == 'high')
                                                <span class="text-red-600 font-bold dark:text-red-400">{{ $request->priority }}</span>
                                            @else
                                                {{ $request->priority }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            @if($request->status == 'pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $request->status }}</span>
                                            @elseif($request->status == 'approved')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full dark:bg-green-900 dark:text-green-300">{{ $request->status }}</span>
                                            @elseif($request->status == 'rejected')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full dark:bg-red-900 dark:text-red-300">{{ $request->status }}</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full dark:bg-gray-700 dark:text-gray-300">{{ $request->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2 flex justify-end">
                                            <a href="{{ route('admin.requests.show', $request->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mt-1 mr-2">View</a>
                                            <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this food request?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline bg-transparent border-0 p-0 cursor-pointer">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No food requests found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
