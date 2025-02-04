@if ($paginator->hasPages())
    <div class="pagination">
        <div class="page-controls">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="prev" disabled>←</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}&perPage={{ request('perPage', 20) }}" class="prev">←</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button disabled>{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="active">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}&perPage={{ request('perPage', 20) }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}&perPage={{ request('perPage', 20) }}" class="next">→</a>
            @else
                <button class="next" disabled>→</button>
            @endif
        </div>
    </div>
@endif