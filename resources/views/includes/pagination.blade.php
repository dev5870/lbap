@if ($paginator->lastPage() > 1)
<nav aria-label="Pagination" class="pagination">
    <ul class="pagination">
        <li class="page-item {{ $paginator->previousPageUrl() === null ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @if($paginator->currentPage() > 3)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item disabled">
                <a class="page-link">...</a>
            </li>
        @endif
        @for($i = 1; $i <= $paginator->lastPage(); $i++)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                <li class="page-item {{ $i === $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item disabled">
                <a class="page-link">...</a>
            </li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
        @endif
        <li class="page-item" {{ $paginator->nextPageUrl() === null ? 'disabled' : '' }}>
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
@endif
