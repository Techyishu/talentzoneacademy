<x-layouts.admin>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.schools.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Add New School</h1>
                <p class="mt-1 text-sm text-gray-600">Create a new school in the system</p>
            </div>
        </div>

        <!-- Create Form -->
        <form action="{{ route('admin.schools.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Basic Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- School Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            School Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- School Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            School Code <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="code"
                            id="code"
                            value="{{ old('code') }}"
                            required
                            placeholder="SCH001"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @enderror"
                        >
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Uppercase letters and numbers only</p>
                    </div>

                    <!-- Receipt Prefix -->
                    <div>
                        <label for="receipt_prefix" class="block text-sm font-medium text-gray-700 mb-2">
                            Receipt Prefix <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="receipt_prefix"
                            id="receipt_prefix"
                            value="{{ old('receipt_prefix', 'RCP') }}"
                            required
                            maxlength="10"
                            placeholder="RCP"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('receipt_prefix') border-red-500 @enderror"
                        >
                        @error('receipt_prefix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Uppercase letters only (e.g., RCP, FEE)</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Contact Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror"
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input
                            type="url"
                            name="website"
                            id="website"
                            value="{{ old('website') }}"
                            placeholder="https://example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('website') border-red-500 @enderror"
                        >
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea
                            name="address"
                            id="address"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('address') border-red-500 @enderror"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Branding -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Branding</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo -->
                    <div class="md:col-span-2">
                        <x-admin.form.file-upload
                            name="logo"
                            label="School Logo"
                            accept="image/jpeg,image/jpg,image/png,image/svg+xml"
                            help="PNG, JPG, or SVG. Max 2MB. Recommended size: 400x400px"
                        />
                    </div>

                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Primary Color
                        </label>
                        <div class="flex gap-2">
                            <input
                                type="color"
                                id="primary_color_picker"
                                value="{{ old('primary_color', '#6366f1') }}"
                                class="h-10 w-20 rounded border border-gray-300 cursor-pointer"
                                onchange="document.getElementById('primary_color').value = this.value"
                            >
                            <input
                                type="text"
                                name="primary_color"
                                id="primary_color"
                                value="{{ old('primary_color', '#6366f1') }}"
                                placeholder="#6366f1"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('primary_color') border-red-500 @enderror"
                                oninput="document.getElementById('primary_color_picker').value = this.value"
                            >
                        </div>
                        @error('primary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Secondary Color
                        </label>
                        <div class="flex gap-2">
                            <input
                                type="color"
                                id="secondary_color_picker"
                                value="{{ old('secondary_color', '#10b981') }}"
                                class="h-10 w-20 rounded border border-gray-300 cursor-pointer"
                                onchange="document.getElementById('secondary_color').value = this.value"
                            >
                            <input
                                type="text"
                                name="secondary_color"
                                id="secondary_color"
                                value="{{ old('secondary_color', '#10b981') }}"
                                placeholder="#10b981"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('secondary_color') border-red-500 @enderror"
                                oninput="document.getElementById('secondary_color_picker').value = this.value"
                            >
                        </div>
                        @error('secondary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Signature Image -->
                    <div class="md:col-span-2">
                        <x-admin.form.file-upload
                            name="signature_image"
                            label="Signature Image (for receipts)"
                            accept="image/jpeg,image/jpg,image/png"
                            help="PNG or JPG. Max 1MB. Will be used on fee receipts."
                        />
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.schools.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                    Create School
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
