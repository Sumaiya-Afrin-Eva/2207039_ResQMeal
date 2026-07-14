<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage NGOs / Volunteers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">All NGOs & Volunteers</h3>
                        <a href="{{ route('admin.ngos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Add New Record</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Phone</th>
                                    <th scope="col" class="px-6 py-3">Organisation</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <th scope="col" class="px-6 py-3">City</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ngos as $ngo)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $ngo->first_name }} {{ $ngo->last_name }}
                                        </th>
                                        <td class="px-6 py-4">{{ $ngo->email }}</td>
                                        <td class="px-6 py-4">{{ $ngo->phone }}</td>
                                        <td class="px-6 py-4">{{ $ngo->organisation ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $ngo->receiver_type) }}</td>
                                        <td class="px-6 py-4">{{ $ngo->city }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('admin.ngos.edit', $ngo->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            <form action="{{ route('admin.ngos.destroy', $ngo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this NGO/Volunteer? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline bg-transparent border-none cursor-pointer">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No NGOs or Volunteers found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $ngos->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
