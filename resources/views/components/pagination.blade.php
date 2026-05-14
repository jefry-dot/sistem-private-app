{{-- resources/views/components/pagination.blade.php --}}

@if ($paginator->hasPages())
@php
    $window = 2;
    $currentPage  = $paginator->currentPage();
    $lastPage     = $paginator->lastPage();
    $start = max(1, $currentPage - $window);
    $end   = min($lastPage, $currentPage + $window);
    $showStartEllipsis = $start > 2;
    $showEndEllipsis   = $end < $lastPage - 1;
@endphp

<nav class="pagination-wrap" aria-label="Pagination">
    <p class="pagination-info">
        {{ number_format($paginator->firstItem()) }}–{{ number_format($paginator->lastItem()) }}
        dari {{ number_format($paginator->total()) }}
    </p>
    <div class="pagination-controls">
        @if ($paginator->onFirstPage())
            <span class="page-btn nav disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Seb.
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn nav" rel="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Seb.
            </a>
        @endif

        <span class="page-btn active page-mobile-current">{{ $currentPage }} / {{ $lastPage }}</span>

        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}" class="page-btn page-num-btn {{ $currentPage === 1 ? 'active' : '' }}">1</a>
            @if ($showStartEllipsis)<span class="page-ellipsis">···</span>@endif
        @endif

        @for ($p = $start; $p <= $end; $p++)
            @if ($p === $currentPage)
                <span class="page-btn page-num-btn active">{{ $p }}</span>
            @else
                <a href="{{ $paginator->url($p) }}" class="page-btn page-num-btn">{{ $p }}</a>
            @endif
        @endfor

        @if ($end < $lastPage)
            @if ($showEndEllipsis)<span class="page-ellipsis">···</span>@endif
            <a href="{{ $paginator->url($lastPage) }}" class="page-btn page-num-btn {{ $currentPage === $lastPage ? 'active' : '' }}">{{ $lastPage }}</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn nav" rel="next">
                Sel.
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="page-btn nav disabled">
                Sel.
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
</nav>
@endif
