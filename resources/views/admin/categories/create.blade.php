<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" value="Category Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus placeholder="e.g. Invoices, Contracts, Designs" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end">
                            <a href="{{ route('admin.categories.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>Create Category</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
