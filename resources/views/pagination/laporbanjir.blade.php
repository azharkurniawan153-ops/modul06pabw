@if ($paginator->hasPages())
<nav class="pager" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
        <span class="disabled">‹ Sebelumnya</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Sebelumnya</a>
    @endif

    @isset($elements)
        @foreach ($elements as $element)
            @if (is_string($element)) <span class="disabled">{{ $element }}</span> @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endisset

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya ›</a>
    @else
        <span class="disabled">Berikutnya ›</span>
    @endif
</nav>
@endif
