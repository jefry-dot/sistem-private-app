<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.groups.store') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" value="Group Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label value="Select Clients for this Group" />
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2 max-h-60 overflow-y-auto border border-gray-200 p-4 rounded-md bg-gray-50">
                                    @foreach($users as $user)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="users[]" value="{{ $user->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-600">{{ $user->name }} ({{ $user->email }})</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('users')" />
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end">
                            <a href="{{ route('admin.groups.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>Create Group</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
