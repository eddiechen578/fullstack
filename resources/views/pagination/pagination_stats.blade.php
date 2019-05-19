@if ($paginator->hasPages())
    <ul class="pagination justify-content-start" role="navigation">
        <li>
            顯示 <strong>{{ ((($paginator->currentPage() -1) * $paginator->perPage()) + 1) }}</strong> 到 <strong>{{ ((($paginator->currentPage() -1) * $paginator->perPage()) + $paginator->count()) }}</strong>筆 / 共<strong>{{ $paginator->total() }}</strong> 筆. 頁 <strong>{{ $paginator->currentPage() }}</strong> /<strong>{{ $paginator->lastPage() }}</strong>
        </li>
    </ul>
@endif