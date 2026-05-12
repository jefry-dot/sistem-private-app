<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Client Groups') }}
            </h2>
            <a href="{{ route('admin.groups.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                + Create Group
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Clients</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groups as $group)
                                    <tr>
                                        <td class="font-bold text-accent">{{ $group->name }}</td>
                                        <td class="text-secondary max-w-xs overflow-hidden text-ellipsis">{{ $group->description ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-indigo">
                                                {{ $group->users_count }} Clients
                                            </span>
                                        </td>
                                        <td class="text-right space-x-2">
                                            <a href="{{ route('admin.groups.edit', $group) }}" class="text-accent hover:underline font-bold text-[11px] uppercase tracking-wider">Edit</a>
                                            <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this group?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger hover:underline font-bold text-[11px] uppercase tracking-wider">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-tertiary italic">No groups created yet.</td>
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
