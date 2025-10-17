<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Create User Button --}}
                    <x-primary-button class="mt-4">
                        <a href="{{ route('user.show') }}" class="text-sm text-white">
                            Create a User
                        </a>
                    </x-primary-button>

                    {{-- Main User Table --}}
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Your Users</h4>

                        @if($users->isEmpty())
                            <p class="text-gray-600">No users found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-4 py-2 text-left text-gray-700">ID</th>
                                            <th class="border px-4 py-2 text-left text-gray-700">Name</th>
                                            <th class="border px-4 py-2 text-left text-gray-700">Email</th>
                                            <th class="border px-4 py-2 text-left text-gray-700">Created At</th>
                                            <th class="border px-4 py-2 text-center text-gray-700">Edit</th>
                                            <th class="border px-4 py-2 text-center text-gray-700">Delete</th>
                                        </tr>
                                    </thead>
                                   <tbody class="divide-y divide-gray-200">
    @foreach ($users as $user)
        <tr>
            <td class="border px-4 py-2">{{ $user->id }}</td>
            <td class="border px-4 py-2">{{ $user->name }}</td>
            <td class="border px-4 py-2">{{ $user->email }}</td>
            <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>

            {{-- Edit Button --}}
            <td class="border px-4 py-2 text-center">
                <a href="{{ route('user.edit', $user->id) }}"
                   class="inline-block bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">
                   Edit
                </a>
            </td>

            {{-- Delete Button --}}
            <td class="border px-4 py-2 text-center">
                <form method="POST" action="{{ route('user.destroy', $user->id) }}" onsubmit="return confirm('Are you sure?')" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
