<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client Profile: ') }} {{ $user->name }}
            </h2>
            <div class="flex space-x-2">
                @if($user->status === 'active')
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase self-center">Active</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase self-center">Inactive</span>
                @endif
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Client Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 md:col-span-1">
                    <div class="text-sm font-medium text-gray-500 uppercase">Email Address</div>
                    <div class="mt-1 text-lg font-bold text-gray-900">{{ $user->email }}</div>
                    
                    <div class="mt-4 text-sm font-medium text-gray-500 uppercase">Member Since</div>
                    <div class="mt-1 text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                    
                    <div class="mt-4 text-sm font-medium text-gray-500 uppercase">Groups Assigned</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse($user->groups as $group)
                            <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded text-xs font-semibold">{{ $group->name }}</span>
                        @empty
                            <span class="text-xs text-gray-500 italic">No groups assigned</span>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 md:col-span-2">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Download Statistics
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <div class="text-xs text-blue-600 font-bold uppercase">Total Downloads</div>
                            <div class="text-2xl font-black text-blue-800">{{ $user->downloadLogs->count() }}</div>
                        </div>
                        <div class="p-4 bg-indigo-50 rounded-lg">
                            <div class="text-xs text-indigo-600 font-bold uppercase">Accessible Files</div>
                            <div class="text-2xl font-black text-indigo-800">{{ $files->count() }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase">Recent Activity</h4>
                        <div class="space-y-2">
                            @forelse($user->downloadLogs()->with('file')->latest()->take(5)->get() as $log)
                                <div class="flex justify-between items-center text-xs p-2 bg-gray-50 rounded">
                                    <span class="text-gray-700">Downloaded <span class="font-bold">{{ $log->file->original_name ?? 'Deleted File' }}</span></span>
                                    <span class="text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div class="text-xs text-gray-500 italic">No download activity yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accessible Files Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Files This Client Can Access</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Access Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($files as $file)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $file->original_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-[10px] uppercase font-bold">
                                                {{ $file->category->name ?? 'None' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $direct = $file->users->contains($user->id);
                                                $viaGroup = $file->groups()->whereHas('users', function($q) use ($user) {
                                                    $q->where('users.id', $user->id);
                                                })->exists();
                                            @endphp
                                            @if($direct && $viaGroup)
                                                <span class="text-indigo-600 font-bold">Direct</span> & <span class="text-purple-600">Group</span>
                                            @elseif($direct)
                                                <span class="text-indigo-600 font-bold">Direct Assignment</span>
                                            @else
                                                <span class="text-purple-600">Via Group Assignment</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ round($file->size / 1024 / 1024, 2) }} MB</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right space-x-2">
                                            <a href="{{ route('file.view', $file) }}" target="_blank" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded" title="Preview File">
                                                Preview
                                            </a>
                                            <a href="{{ route('file.download', $file) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No files assigned to this client yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
