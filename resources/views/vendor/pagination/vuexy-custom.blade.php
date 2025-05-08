@if ($paginator->hasPages())
<nav>
  <ul class="pagination pagination-sm justify-content-end mb-0">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="page-item disabled" aria-disabled="true">
      <a class="page-link" href="#" tabindex="-1">‹</a>
    </li>
    @else
    <li class="page-item">
      <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
    </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- Dots --}}
    @if (is_string($element))
    <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
    @endif

    {{-- Page Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="page-item active">
      <a class="page-link">{{ $page }}</a>
    </li>
    @else
    <li class="page-item">
      <a class="page-link" href="{{ $url }}">{{ $page }}</a>
    </li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li class="page-item">
      <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
    </li>
    @else
    <li class="page-item disabled" aria-disabled="true">
      <a class="page-link" href="#">›</a>
    </li>
    @endif
  </ul>
</nav>
@endif
