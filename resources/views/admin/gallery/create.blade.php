<x-layouts.admin>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gallery.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Upload Gallery Images</h1>
                <p class="mt-1 text-sm text-gray-600">Upload multiple images at once for your public website gallery</p>
            </div>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="category"
                        id="category"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror"
                    >
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Select the category for all uploaded images</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title (Optional)
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        placeholder="Gallery Image"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Optional title for the images (will be used for all if not specified individually)</p>
                </div>

                <!-- Image Upload (Multi-file with Preview) -->
                <div x-data="{
                    files: [],
                    isDragging: false,
                    handleFiles(event) {
                        const fileList = event.target.files || event.dataTransfer.files;
                        this.files = Array.from(fileList).slice(0, 10); // Max 10 images
                        this.$refs.fileInput.files = this.createFileList(this.files);
                    },
                    createFileList(files) {
                        const dataTransfer = new DataTransfer();
                        files.forEach(file => dataTransfer.items.add(file));
                        return dataTransfer.files;
                    },
                    removeFile(index) {
                        this.files.splice(index, 1);
                        this.$refs.fileInput.files = this.createFileList(this.files);
                    },
                    formatSize(bytes) {
                        return bytes < 1024 * 1024
                            ? (bytes / 1024).toFixed(1) + ' KB'
                            : (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                    }
                }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Images <span class="text-red-500">*</span>
                    </label>

                    <!-- Drop Zone -->
                    <div
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="isDragging = false; handleFiles($event)"
                        :class="isDragging ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300'"
                        class="border-2 border-dashed rounded-lg p-8 text-center transition-colors duration-150 cursor-pointer hover:border-indigo-400"
                        @click="$refs.fileInput.click()"
                    >
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-indigo-600">Click to upload</span> or drag and drop
                        </p>
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG, or WebP up to 5MB each (max 10 images)</p>
                    </div>

                    <input
                        type="file"
                        name="images[]"
                        x-ref="fileInput"
                        @change="handleFiles($event)"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        multiple
                        required
                        class="hidden"
                    >

                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview Grid -->
                    <div x-show="files.length > 0" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="relative group">
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                    <img
                                        :src="URL.createObjectURL(file)"
                                        :alt="file.name"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                <button
                                    type="button"
                                    @click.stop="removeFile(index)"
                                    class="absolute -top-2 -right-2 p-1 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-150"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                <div class="mt-1 text-xs text-gray-600 truncate" x-text="file.name"></div>
                                <div class="text-xs text-gray-500" x-text="formatSize(file.size)"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="ml-3 text-sm text-blue-800">
                            <p class="font-medium">Image Processing</p>
                            <p class="mt-1">Images will be automatically resized and optimized for web display. Thumbnails will be generated for faster loading.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.gallery.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                    Upload Images
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
