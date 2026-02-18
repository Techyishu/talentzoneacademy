<x-layouts.admin>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.schools.show', $school) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create School Admin</h1>
                <p class="mt-1 text-sm text-gray-600">Create admin account for <strong>{{ $school->name }}</strong></p>
            </div>
        </div>

        <form action="{{ route('admin.schools.admins.store', $school) }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Admin Details</h2>

                <div class="space-y-6">
                    <x-admin.form.input
                        type="text"
                        name="name"
                        label="Full Name"
                        :required="true"
                        placeholder="e.g. School Admin"
                    />

                    <x-admin.form.input
                        type="email"
                        name="email"
                        label="Email Address"
                        :required="true"
                        placeholder="e.g. admin@school.com"
                    />

                    <x-admin.form.input
                        type="password"
                        name="password"
                        label="Password"
                        :required="true"
                        help="Minimum 8 characters"
                    />

                    <x-admin.form.input
                        type="password"
                        name="password_confirmation"
                        label="Confirm Password"
                        :required="true"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.schools.show', $school) }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                    Create Admin Account
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
