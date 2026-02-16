<x-layouts.admin>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Change Password</h1>
                <p class="mt-1 text-sm text-gray-600">Update your account password</p>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 p-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Password</h2>

                <div class="space-y-6">
                    <x-admin.form.input
                        type="password"
                        name="current_password"
                        label="Current Password"
                        :required="true"
                    />

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
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
