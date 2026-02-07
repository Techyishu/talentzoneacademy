<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fee Structures
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Session Selector and Clone -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="session_select" class="block text-sm font-bold text-gray-700 mb-2">
                                Select Academic Session
                            </label>
                            <select id="session_select"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    onchange="window.location.href='{{ route('admin.fee-structures.index') }}?session_id=' + this.value">
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" {{ $selectedSession && $selectedSession->id == $session->id ? 'selected' : '' }}>
                                        {{ $session->name }} ({{ $session->start_date->format('M Y') }} - {{ $session->end_date->format('M Y') }})
                                        @if($session->is_current) ⭐ Current @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if($sessions->count() > 1 && $selectedSession)
                            <div class="flex-1 min-w-[200px]">
                                <button type="button"
                                        onclick="document.getElementById('cloneModal').classList.remove('hidden')"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Clone from Another Session
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($selectedSession && $classes->count() > 0 && $feeHeads->count() > 0)
                <!-- Fee Structure Matrix -->
                <form action="{{ route('admin.fee-structures.bulk-update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="session_id" value="{{ $selectedSession->id }}">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Fee Structure for {{ $selectedSession->name }}
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                Class / Fee Head
                                            </th>
                                            @foreach($feeHeads as $feeHead)
                                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">
                                                    {{ $feeHead->name }}
                                                    @if($feeHead->code)
                                                        <br><span class="text-xs text-gray-400">({{ $feeHead->code }})</span>
                                                    @endif
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($classes as $class)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r bg-gray-50">
                                                    {{ $class->name }}
                                                </td>
                                                @foreach($feeHeads as $feeHead)
                                                    @php
                                                        $structure = $feeStructures[$class->id][$feeHead->id] ?? null;
                                                        $amount = $structure ? $structure->amount : '';
                                                        $frequency = $structure ? $structure->frequency : 'monthly';
                                                    @endphp
                                                    <td class="px-2 py-2 border-r">
                                                        <div class="flex flex-col space-y-1">
                                                            <input type="number"
                                                                   name="structures[{{ $class->id }}_{{ $feeHead->id }}][amount]"
                                                                   step="0.01"
                                                                   min="0"
                                                                   value="{{ $amount }}"
                                                                   placeholder="0.00"
                                                                   class="w-full px-2 py-1 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                            <select name="structures[{{ $class->id }}_{{ $feeHead->id }}][frequency]"
                                                                    class="w-full px-2 py-1 text-xs border rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                                <option value="monthly" {{ $frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                                <option value="quarterly" {{ $frequency == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                                <option value="annual" {{ $frequency == 'annual' ? 'selected' : '' }}>Annual</option>
                                                            </select>
                                                            <input type="hidden" name="structures[{{ $class->id }}_{{ $feeHead->id }}][class_id]" value="{{ $class->id }}">
                                                            <input type="hidden" name="structures[{{ $class->id }}_{{ $feeHead->id }}][fee_head_id]" value="{{ $feeHead->id }}">
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                    Save Fee Structures
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        @if(!$selectedSession)
                            <p class="text-gray-500 mb-4">Please create an academic session first.</p>
                            <a href="{{ route('admin.academic-sessions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Academic Session
                            </a>
                        @elseif($classes->count() == 0)
                            <p class="text-gray-500 mb-4">Please create classes first.</p>
                            <a href="{{ route('admin.classes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Class
                            </a>
                        @elseif($feeHeads->count() == 0)
                            <p class="text-gray-500 mb-4">Please create fee heads first.</p>
                            <a href="{{ route('admin.fee-heads.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Fee Head
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Info Box -->
            <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>How to use:</strong> Enter the fee amount for each class and fee head combination. Leave blank or enter 0 to skip. Select frequency (Monthly, Quarterly, or Annual) for each fee. Click "Save Fee Structures" to apply changes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clone Modal -->
    @if($sessions->count() > 1 && $selectedSession)
        <div id="cloneModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Clone Fee Structures</h3>
                    <form action="{{ route('admin.fee-structures.clone') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">From Session</label>
                            <select name="from_session_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                <option value="">Select session to copy from</option>
                                @foreach($sessions->where('id', '!=', $selectedSession->id) as $session)
                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="to_session_id" value="{{ $selectedSession->id }}">
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="overwrite" class="form-checkbox h-4 w-4 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Overwrite existing structures</span>
                            </label>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="document.getElementById('cloneModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Clone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-layouts.admin>
