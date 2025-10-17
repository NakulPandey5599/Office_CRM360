<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Create User Button (separated) --}}
            <div class="mb-6">
                <x-primary-button>
                    <a href="{{ route('admin.create') }}" class="text-sm text-white">Create User</a>
                </x-primary-button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Main User Table --}}
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Your Users</h4>

                        {{-- @if ($users->isEmpty())
                            <p class="text-gray-600">No users found.</p>
                        @else --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2">ID</th>
                                        <th class="border px-4 py-2">Photo</th>
                                        <th class="border px-4 py-2">Name</th>
                                        <th class="border px-4 py-2">Email</th>
                                        <th class="border px-4 py-2">Created At</th>
                                        <th class="border px-4 py-2 text-center">Edit</th>
                                        <th class="border px-4 py-2 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $user->id }}</td>
                                            <td class="border px-4 py-2">
                                                @if ($user->photo)
                                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <span class="text-gray-500">No Photo</span>
                                                @endif
                                            <td class="border px-4 py-2">{{ $user->name }}</td>
                                            <td class="border px-4 py-2">{{ $user->email }}</td>
                                            <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="border px-4 py-2 text-center">
                                                <a href="{{ route('admin.edit', $user->id) }}"
                                                    class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">Edit</a>
                                            </td>
                                            <td class="border px-4 py-2 text-center">
                                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- @endif --}}
                    </div> {{-- Close mt-6 div --}}

                </div> {{-- Close p-6 div --}}
            </div> {{-- Close bg-white div --}}
        </div> {{-- Close max-w-7xl div --}}
    </div> {{-- Close py-12 div --}}
</x-app-layout>
