@php
    /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\SchoolClass> $classes */
@endphp
<x-layouts.admin>
    <x-slot name="title">Classes & Sections</x-slot>

    <div class="space-y-6" x-data="classManager()">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Classes & Sections</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage classes and their sections in one place</p>
            </div>
            <button @click="showAddClass = true"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white gradient-primary shadow-lg hover:opacity-90 transition-all">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Class
            </button>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl bg-red-50 p-4 border border-red-200">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Add Class Modal -->
        <div x-show="showAddClass" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-black/40" @click="showAddClass = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 z-10"
                @click.outside="showAddClass = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Add New Class</h3>
                    <button @click="showAddClass = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.classes.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Class Name -->
                        <div>
                            <label for="modal_name" class="block text-sm font-medium text-slate-700 mb-1">Class Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="modal_name"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="e.g., Nursery, Class 1, Class 2" required>
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label for="modal_display_order"
                                class="block text-sm font-medium text-slate-700 mb-1">Display Order</label>
                            <input type="number" name="display_order" id="modal_display_order"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                value="0" min="0">
                            <p class="text-xs text-slate-500 mt-1">Lower numbers appear first</p>
                        </div>

                        <!-- Sections -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sections</label>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <template x-for="(section, index) in newSections" :key="index">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                        <input type="hidden" :name="'sections[]'" :value="section">
                                        <span x-text="section"></span>
                                        <button type="button" @click="newSections.splice(index, 1)"
                                            class="text-primary-600 hover:text-primary-900">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                            </div>
                            <div class="flex gap-2">
                                <input type="text" x-model="newSectionName" @keydown.enter.prevent="addNewSection()"
                                    class="flex-1 rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                    placeholder="e.g., A, B, C">
                                <button type="button" @click="addNewSection()"
                                    class="px-3 py-2 rounded-xl text-sm font-medium text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 transition-colors">
                                    Add
                                </button>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Type section name and press Enter or click Add</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                        <button type="button" @click="showAddClass = false"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all">
                            Create Class
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Classes List -->
        @if($classes->count() > 0)
            <div class="space-y-4">
                @foreach($classes as $schoolClass)
                    <div class="card-premium overflow-hidden"
                        x-data="{ expanded: false, showAddSection: false, sectionName: '' }">
                        <!-- Class Header -->
                        <div class="p-4 sm:p-5 flex items-center justify-between cursor-pointer" @click="expanded = !expanded">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl gradient-primary flex items-center justify-center text-white font-bold text-sm sm:text-lg shadow-md">
                                    {{ substr($schoolClass->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $schoolClass->name }}</h3>
                                    <div class="flex items-center gap-3 mt-0.5">
                                        <span class="text-xs text-slate-500">
                                            {{ $schoolClass->sections->count() }} section(s)
                                        </span>
                                        <span class="text-xs text-slate-400">•</span>
                                        <span class="text-xs text-slate-500">
                                            {{ $schoolClass->students->count() }} student(s)
                                        </span>
                                        @if($schoolClass->display_order)
                                            <span class="text-xs text-slate-400">•</span>
                                            <span class="text-xs text-slate-500">Order: {{ $schoolClass->display_order }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Quick Actions -->
                                <div class="hidden sm:flex items-center gap-1" @click.stop>
                                    <a href="{{ route('admin.classes.edit', $schoolClass) }}"
                                        class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition-colors"
                                        title="Edit Class">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if($schoolClass->students->count() === 0)
                                        <form action="{{ route('admin.classes.destroy', $schoolClass) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $schoolClass->name }}?');">
                                            @csrf @method('DELETE')
                                            <button
                                                class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                title="Delete Class">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <!-- Expand Arrow -->
                                <svg class="w-5 h-5 text-slate-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Sections Panel (Expandable) -->
                        <div x-show="expanded" x-collapse class="border-t border-slate-100">
                            <div class="p-4 sm:p-5 bg-slate-50/50">
                                <!-- Sections List -->
                                @if($schoolClass->sections->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($schoolClass->sections as $section)
                                            <div
                                                class="group inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-slate-200 shadow-sm">
                                                <span
                                                    class="w-7 h-7 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold">
                                                    {{ $section->name }}
                                                </span>
                                                <div class="text-xs">
                                                    <span class="font-medium text-slate-700">Section {{ $section->name }}</span>
                                                    <span class="text-slate-400 ml-1">({{ $section->students->count() }})</span>
                                                </div>
                                                @if($section->students->count() === 0)
                                                    <form action="{{ route('admin.sections.destroy', [$schoolClass, $section]) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Delete Section {{ $section->name }}?');">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="ml-1 text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100"
                                                            title="Delete section">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500 mb-4">No sections yet. Add one below.</p>
                                @endif

                                <!-- Add Section Inline -->
                                <div x-show="!showAddSection" class="flex flex-wrap gap-2">
                                    <button @click="showAddSection = true"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium text-primary-700 bg-primary-50 hover:bg-primary-100 border border-primary-200 border-dashed transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Section
                                    </button>

                                    <!-- Mobile Actions -->
                                    <div class="sm:hidden flex gap-2">
                                        <a href="{{ route('admin.classes.edit', $schoolClass) }}"
                                            class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                            Edit Class
                                        </a>
                                        @if($schoolClass->students->count() === 0)
                                            <form action="{{ route('admin.classes.destroy', $schoolClass) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Delete {{ $schoolClass->name }}?');">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <!-- Add Section Form -->
                                <div x-show="showAddSection" x-cloak>
                                    <form action="{{ route('admin.sections.store', $schoolClass) }}" method="POST"
                                        class="flex gap-2">
                                        @csrf
                                        <input type="text" name="name" x-model="sectionName"
                                            class="flex-1 rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                            placeholder="Section name (e.g., A, B, C)" required autofocus>
                                        <button type="submit"
                                            class="px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all">
                                            Add
                                        </button>
                                        <button type="button" @click="showAddSection = false; sectionName = ''"
                                            class="px-3 py-2 rounded-xl text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card-premium p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 mb-1">No classes yet</h3>
                <p class="text-sm text-slate-500 mb-6">Start by adding your school classes and sections</p>
                <button @click="showAddClass = true"
                    class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white gradient-primary shadow-lg hover:opacity-90 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Your First Class
                </button>
            </div>
        @endif
    </div>

    <script>
        function classManager() {
            return {
                showAddClass: false,
                newSections: [],
                newSectionName: '',

                addNewSection() {
                    const name = this.newSectionName.trim();
                    if (name && !this.newSections.includes(name)) {
                        this.newSections.push(name);
                        this.newSectionName = '';
                    }
                }
            };
        }
    </script>
</x-layouts.admin>