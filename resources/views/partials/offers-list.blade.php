@foreach ($offers as $offer)
    <article class="job-card">
        <h2 class="job-title">{{ $offer->title }}</h2>
        <p class="job-location">{{ $offer->place }}</p>
        <div class="job-tags">
            <span class="job-tag-1">{{ $offer->work_type }}</span>
            <span class="job-tag">{{ $offer->category }}</span>
            {{-- @php
                $category = $categories->firstWhere('offer_id', $offer->id);
            @endphp

            @if ($category)
                <span class="job-tag">{{ $category->name }}</span>
            @else
                <span class="job-tag">No hay categorías disponibles</span>
            @endif --}}
            <span class="job-tag">{{ $offer->starting_salary . "-" . $offer->final_salary }}</span>
        </div>
        <button onclick="document.getElementById('form-get-offer-{{ $offer->id }}').submit();" class="apply-button">Postular</button>
            <form method="GET" id="form-get-offer-{{ $offer->id }}" action="{{ route('candidat.show.offer', ['id' => $offer->id]) }}">
            </form>
    </article>
@endforeach
