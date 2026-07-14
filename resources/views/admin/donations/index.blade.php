<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Donations') }}
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
                        <h3 class="text-lg font-semibold">All Donations</h3>
                        <a href="{{ route('admin.donations.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Add New Donation</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Food Item</th>
                                    <th scope="col" class="px-6 py-3">Donor</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">Quantity</th>
                                    <th scope="col" class="px-6 py-3">Serves</th>
                                    <th scope="col" class="px-6 py-3">Pickup Window</th>
                                    <th scope="col" class="px-6 py-3">Emergency</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donations as $donation)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $donation->food_name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            @if($donation->donor)
                                                {{ $donation->donor->first_name }} {{ $donation->donor->last_name }}
                                            @else
                                                {{ $donation->donor_name }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 capitalize">{{ $donation->category }}</td>
                                        <td class="px-6 py-4">{{ $donation->quantity }} {{ $donation->unit }}</td>
                                        <td class="px-6 py-4">{{ $donation->serves }}</td>
                                        <td class="px-6 py-4">{{ $donation->pickup_from }} - {{ $donation->pickup_to }}</td>
                                        <td class="px-6 py-4">
                                            @if($donation->emergency)
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full dark:bg-red-900 dark:text-red-300">Yes</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full dark:bg-gray-700 dark:text-gray-300">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('admin.donations.edit', $donation->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            <form action="{{ route('admin.donations.destroy', $donation->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this donation?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline bg-transparent border-none cursor-pointer">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                            No donations found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $donations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
