@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'block' => false,
    'disabled' => false,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60';

    $sizes = [
        'sm' => 'min-h-10 rounded-xl px-3.5 py-2 text-xs',
        'md' => 'min-h-11 rounded-xl px-4 py-2.5 text-sm',
        'lg' => 'min-h-12 rounded-xl px-5 py-3 text-sm',
    ];

    $variants = [
        'primary' => 'border border-[#2B4C3F] bg-[#2B4C3F] text-white hover:bg-[#1E362C] focus:ring-[#A7C5B5]',
        'secondary' => 'border border-[#C9D8D0] bg-white text-[#2B4C3F] hover:border-[#2B4C3F] hover:bg-[#F3F7F5] focus:ring-[#A7C5B5]',
        'muted' => 'border border-[#E6E4DD] bg-[#FAF9F6] text-[#5C6E65] hover:bg-[#F2F0EA] focus:ring-[#D5D3C7]',
        'warning' => 'border border-[#B7791F] bg-[#B7791F] text-white hover:bg-[#975A16] focus:ring-[#F2D8A8]',
        'danger' => 'border border-[#F5C2C2] bg-[#FDF2F2] text-[#B91C1C] hover:bg-[#F8DADA] focus:ring-[#F5C2C2]',
        'disabled' => 'border border-[#E6E4DD] bg-[#F3F4F6] text-[#8A9C91] cursor-not-allowed shadow-none',
    ];

    $classes = trim(implode(' ', [
        $base,
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
        $block ? 'w-full' : '',
    ]));
@endphp

@if ($href && ! $disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" @disabled($disabled) {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
