@if ($paginator->hasPages())
    <div class="pagination">
        <div class="page-controls">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="prev" disabled>←</button>
            @else
                <a href="{{ $paginator->previousPageUrl() . '&start_date=' . request('start_date', '') . '&end_date=' . request('end_date', '') }}" class="prev">←</a>
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
                            <a href="{{ $url . '&start_date=' . request('start_date', '') . '&end_date=' . request('end_date', '') }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() . '&start_date=' . request('start_date', '') . '&end_date=' . request('end_date', '') }}" class="next">→</a>
            @else
                <button class="next" disabled>→</button>
            @endif
        </div>
    </div>
@endif