@php
    $ratingCount = (int) ($count ?? 0);
    $ratingValue = $ratingCount > 0 ? (float) ($rating ?? 0) : 0;
@endphp

@if ($ratingCount > 0)
    <span class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-xs font-bold text-[#B7791F] shadow-sm border border-[#F2D8A8]">
        <span>&#9733;</span>
        <span>{{ number_format($ratingValue, 1) }}</span>
        <span class="font-medium text-[#8A9C91]">({{ $ratingCount }} ulasan)</span>
    </span>
@else
    <span class="inline-flex items-center rounded-full bg-white/95 px-2.5 py-1 text-[10px] font-semibold text-[#8A9C91] shadow-sm border border-[#E6E4DD]">
        Belum ada ulasan
    </span>
@endif
