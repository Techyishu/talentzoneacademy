@props(['columns' => [], 'rows' => [], 'actions' => true, 'emptyMessage' => 'No records found'])

<div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    @foreach($columns as $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            {{ $column['label'] ?? $column }}
                        </th>
                    @endforeach
                    @if($actions)
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($rows as $row)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                @if(isset($column['key']))
                                    {{ data_get($row, $column['key']) }}
                                @else
                                    {{ $row }}
                                @endif
                            </td>
                        @endforeach
                        @if($actions)
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{ $slot }}
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($actions ? 1 : 0) }}" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm font-medium text-slate-500">{{ $emptyMessage }}</p>
                                <p class="text-xs text-slate-400 mt-1">Get started by creating your first record</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
