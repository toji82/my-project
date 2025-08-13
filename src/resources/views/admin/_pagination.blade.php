@if ($paginator->hasPages())
<nav class="pg" role="navigation" aria-label="Pagination Navigation">
    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="pg-prev pg-disabled" aria-disabled="true" aria-label="前のページ">&lt;</span>
    @else
        <a class="pg-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="前のページ">&lt;</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="pg-ellipsis">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="pg-page is-active" aria-current="page">{{ $page }}</span>
                @else
                    <a class="pg-page" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a class="pg-next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="次のページ">&gt;</a>
    @else
        <span class="pg-next pg-disabled" aria-disabled="true" aria-label="次のページ">&gt;</span>
    @endif
</nav>
@endif
