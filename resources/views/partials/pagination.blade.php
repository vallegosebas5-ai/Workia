@if ($paginator->hasPages())
<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a></li>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled"><span class="page-link">{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a></li>
    @else
        <li class="disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
    @endif
</ul>
@endif
