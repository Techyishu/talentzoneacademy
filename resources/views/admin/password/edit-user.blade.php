<x-layouts.admin>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.schools.show', $user->school_id) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Reset Password</h1>
                <p class="mt-1 text-sm text-gray-600">Set a new password for <strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
            </div>
        </div>

        <form action="{{ route('admin.users.password.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">New Password</h2>

                <div class="space-y-6">
                    <x-admin.form.input
                        type="password"
                        name="password"
                        label="New Password"
                        :required="true"
                        help="Minimum 8 characters"
                    />

                    <x-admin.form.input
                        type="password"
                        name="password_confirmation"
                        label="Confirm New Password"
                        :required="true"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.schools.show', $user->school_id) }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
