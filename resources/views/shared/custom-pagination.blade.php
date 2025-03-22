@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><span class="oi oi-arrow-left"></span> Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="oi oi-arrow-left"></span> Previous</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        <li class="page-item active">
            <span class="page-link">{{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }}</span>
        </li>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <span class="oi oi-arrow-right"></span></a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next <span class="oi oi-arrow-right"></span></span>
            </li>
        @endif
    </ul>
@endif
