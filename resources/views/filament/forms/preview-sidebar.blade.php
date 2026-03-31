<div class="space-y-6 p-6 border rounded-2xl bg-white dark:bg-gray-900 shadow-xl min-h-[500px] border-gray-100 dark:border-gray-800">
    {{-- Form Header --}}
    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-2">
        <h2 class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-white {{ app()->getLocale() === 'dv' ? 'dv-font text-right' : '' }}">
            {{ $get('title') ?: 'New Form Template' }}
        </h2>
    </div>

    @php
        $content = $get('content') ?: [];
    @endphp

    @if(count($content) > 0)
        <div class="space-y-5">
            @foreach($content as $block)
                @php 
                    $isDhivehi = str_contains(json_encode($block), 'dv') || app()->getLocale() === 'dv';
                @endphp

                {{-- 1. SECTION HEADER BLOCK --}}
                @if($block['type'] === 'section_break')
                    <div class="pt-4 pb-1 border-b border-primary-500/20 {{ $isDhivehi ? 'text-right' : '' }}">
                        <h3 class="text-md font-bold text-primary-600 {{ $isDhivehi ? 'dv-font' : '' }}">
                            {{ $block['data']['title'] ?? 'Section Title' }}
                        </h3>
                        @if(!empty($block['data']['description']))
                            <p class="text-xs text-gray-500 {{ $isDhivehi ? 'dv-font' : '' }}">
                                {{ $block['data']['description'] }}
                            </p>
                        @endif
                    </div>

                {{-- 2. RICH CONTENT / DESCRIPTION --}}
                @elseif($block['type'] === 'content_block')
                    <div class="prose prose-sm max-w-none text-gray-600 dark:text-gray-400 {{ $isDhivehi ? 'text-right dv-font' : '' }}">
                        {!! $block['data']['content'] ?? 'Instruction text...' !!}
                    </div>

                {{-- 3. FIELD BLOCKS --}}
                @else
                    <div class="group relative {{ $isDhivehi ? 'text-right' : '' }}" dir="{{ $isDhivehi ? 'rtl' : 'ltr' }}">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 {{ $isDhivehi ? 'dv-font' : '' }}">
                            {{ $block['data']['label'] ?? 'Unnamed Field' }}
                            @if(!empty($block['data']['required'])) 
                                <span class="text-red-500 mx-1">*</span> 
                            @endif
                        </label>

                        {{-- Input --}}
                        @if($block['type'] === 'input')
                            <input type="text" disabled 
                                placeholder="{{ $block['data']['placeholder'] ?? '' }}" 
                                value="{{ $block['data']['default_value'] ?? '' }}"
                                class="w-full rounded-lg border-gray-200 bg-gray-50/50 text-sm py-2 px-3 shadow-sm {{ $isDhivehi ? 'dv-font' : '' }}">

                        {{-- Textarea --}}
                        @elseif($block['type'] === 'textarea')
                            <textarea disabled 
                                class="w-full rounded-lg border-gray-200 bg-gray-50/50 text-sm py-2 px-3 shadow-sm min-h-[80px] {{ $isDhivehi ? 'dv-font' : '' }}"></textarea>

                        {{-- Date Picker --}}
                        @elseif($block['type'] === 'date_picker')
                            <div class="flex items-center justify-between w-full rounded-lg border border-gray-200 bg-gray-50/50 px-3 py-2 text-sm text-gray-400">
                                <span class="{{ $isDhivehi ? 'dv-font' : '' }}">Select Date...</span>
                                <x-heroicon-m-calendar class="w-4 h-4" />
                            </div>

                        {{-- Dropdown --}}
                        @elseif($block['type'] === 'dropdown')
                            <div class="flex items-center justify-between w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm">
                                <span class="text-gray-400 {{ $isDhivehi ? 'dv-font' : '' }}">Choose an option...</span>
                                <x-heroicon-m-chevron-down class="w-4 h-4 text-gray-400" />
                            </div>

                        {{-- Color Picker --}}
                        @elseif($block['type'] === 'color_picker')
                            <div class="flex items-center gap-3 p-2 border border-gray-200 rounded-lg bg-gray-50/30">
                                <div class="w-8 h-8 rounded-md border shadow-sm" style="background-color: {{ $block['data']['default_color'] ?? '#ffffff' }}"></div>
                                <span class="text-xs text-gray-500 uppercase">{{ $block['data']['default_color'] ?? '#FFFFFF' }}</span>
                            </div>

                        {{-- File Upload --}}
                        @elseif($block['type'] === 'file_upload')
                            <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-lg p-4 bg-gray-50/30">
                                <x-heroicon-m-arrow-up-tray class="w-5 h-5 text-gray-400 mb-1" />
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider font-bold">
                                    {{ $block['data']['allowed_types'] ?? 'Files' }} (Max {{ $block['data']['max_size'] ?? '2' }}MB)
                                </span>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
            
            {{-- Submit Button Mockup --}}
            <div class="pt-6">
                <button disabled class="w-full py-2.5 bg-primary-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-primary-500/20 opacity-90">
                    {{ app()->getLocale() === 'dv' ? 'ފޮނުވާ' : 'Submit Application' }}
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
            <x-heroicon-o-sparkles class="w-8 h-8 text-primary-500 mb-4 animate-pulse" />
            <p class="text-sm font-medium text-gray-500">Your form is empty</p>
            <p class="text-xs text-gray-400 mt-1 text-center px-6">Start adding components to see how your council form will look.</p>
        </div>
    @endif
</div>