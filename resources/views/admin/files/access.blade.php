<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Access for: ') }} {{ $file->original_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.file.access.update', $file) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Select Clients -->
                            <div>
                                <h4 class="font-bold text-gray-700 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Share with Clients
                                </h4>
                                <div class="space-y-2 max-h-80 overflow-y-auto border border-gray-200 p-4 rounded-md bg-gray-50">
                                    @foreach($clients as $client)
                                        <label class="flex items-center p-2 hover:bg-white rounded transition cursor-pointer">
                                            <input type="checkbox" name="users[]" value="{{ $client->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                @if($file->users->contains($client->id)) checked @endif>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $client->email }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Select Groups -->
                            <div>
                                <h4 class="font-bold text-gray-700 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Share with Groups
                                </h4>
                                <div class="space-y-2 max-h-80 overflow-y-auto border border-gray-200 p-4 rounded-md bg-gray-50">
                                    @foreach($groups as $group)
                                        <label class="flex items-center p-2 hover:bg-white rounded transition cursor-pointer">
                                            <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500"
                                                @if($file->groups->contains($group->id)) checked @endif>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $group->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $group->users_count }} members</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Cancel and Go Back</a>
                            <x-primary-button>Update Access Permissions</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
