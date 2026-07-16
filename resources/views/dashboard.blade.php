<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Donors</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalDonors }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total NGOs / Volunteers</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalNGOs }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Donations</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalDonations }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Requests</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalRequests }}</div>
                </div>
            </div>

            <!-- Search Hub Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Unified Search Hub</h3>
                    
                    <form action="{{ route('dashboard') }}#search-results" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="search-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Keyword (Name, City, Pickup Location)</label>
                            <input type="text" name="q" id="search-input" value="{{ $q ?? '' }}" placeholder="Enter keyword..." class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label for="date-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date (Falls inside Pickup Window)</label>
                            <input type="date" name="date" id="date-input" value="{{ $date ?? '' }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Search
                            </button>
                            @if($hasSearch)
                                <a href="{{ route('dashboard') }}" class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center items-center">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($hasSearch)
                        <div id="search-results" class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-md font-semibold mb-3">Search Results</h4>
                            @if(count($searchResults) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-900">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name / Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location / City</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Details</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pickup Window</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($searchResults as $row)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        @if($row->type === 'donor')
                                                            <span style="padding: 2px 8px; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-flex; line-height: 1.25rem; background-color: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);">Donor</span>
                                                        @elseif($row->type === 'ngo')
                                                            <span style="padding: 2px 8px; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-flex; line-height: 1.25rem; background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3);">NGO/Volunteer</span>
                                                        @elseif($row->type === 'donation')
                                                            <span style="padding: 2px 8px; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-flex; line-height: 1.25rem; background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3);">Donation</span>
                                                        @else
                                                            <span style="padding: 2px 8px; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; display: inline-flex; line-height: 1.25rem; background-color: rgba(139, 92, 246, 0.15); color: #8b5cf6; border: 1px solid rgba(139, 92, 246, 0.3);">Food Request</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $row->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $row->city }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $row->detail }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono text-xs">
                                                        @if($row->date_from)
                                                            {{ \Carbon\Carbon::parse($row->date_from)->format('M d, g:i A') }} - {{ \Carbon\Carbon::parse($row->date_to)->format('M d, g:i A') }}
                                                        @else
                                                            <span class="text-gray-400 dark:text-gray-600">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No results matching your criteria were found.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- CRUD Operations Hub -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">CRUD Operations</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                        <!-- Manage Donors Card -->
                        <a href="{{ route('admin.donors') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Manage Donors</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">View, create, update, or delete donor profiles from the database.</p>
                        </a>

                        <!-- Manage NGOs Card -->
                        <a href="{{ route('admin.ngos') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Manage NGOs / Volunteers</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">View, create, update, or delete NGO and Volunteer profiles.</p>
                        </a>

                        <!-- Manage Donations Card -->
                        <a href="{{ route('admin.donations') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Manage Donations</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Oversee all food donations added to the system and moderate them.</p>
                        </a>

                        <!-- Manage Requests Card -->
                        <a href="{{ route('admin.requests') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Manage Food Requests</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Monitor and update the status of food requests across the platform.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
