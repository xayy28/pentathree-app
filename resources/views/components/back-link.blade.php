@php
    $label = $label ?? 'Kembali';
    $class = $class ?? '';
@endphp

<a href="{{ $href }}"
    class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-[#C9D8D0] bg-white px-4 py-2.5 text-sm font-semibold text-[#2B4C3F] shadow-sm transition-all hover:border-[#2B4C3F] hover:bg-[#F3F7F5] focus:outline-none focus:ring-2 focus:ring-[#A7C5B5] focus:ring-offset-2 {{ $class }}"
    aria-label="{{ $label }}">
    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#EAF2EE] text-[#2B4C3F]">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </span>
    <span>{{ $label }}</span>
</a>