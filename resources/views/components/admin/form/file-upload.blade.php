@props(['label' => '', 'name' => '', 'accept' => 'image/*', 'required' => false, 'help' => '', 'preview' => null])

<div class="space-y-2" x-data="{
    fileName: '',
    preview: '{{ $preview }}',
    handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.fileName = file.name;
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => { this.preview = e.target.result; };
                reader.readAsDataURL(file);
            }
        }
    }
}">
    @if($label)
        <label class="block text-sm font-medium text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="flex items-start space-x-4">
        <!-- Preview -->
        <div x-show="preview" class="flex-shrink-0">
            <img :src="preview" alt="Preview" class="h-20 w-20 rounded-lg object-cover border-2 border-slate-200 shadow-sm">
        </div>

        <!-- Upload Area -->
        <div class="flex-1">
            <label class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-slate-300 border-dashed rounded-xl appearance-none cursor-pointer hover:border-primary-400 hover:bg-primary-50 focus:outline-none">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <div class="text-center">
                        <span class="text-sm font-medium text-slate-600" x-text="fileName || 'Click to upload'"></span>
                        <p class="text-xs text-slate-500">or drag and drop</p>
                    </div>
                </div>
                <input
                    type="file"
                    id="{{ $name }}"
                    name="{{ $name }}"
                    accept="{{ $accept }}"
                    class="hidden"
                    {{ $required ? 'required' : '' }}
                    @change="handleFileSelect($event)"
                />
            </label>
        </div>
    </div>

    @if($help)
        <p class="text-xs text-slate-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-sm text-red-600 flex items-center space-x-1">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
