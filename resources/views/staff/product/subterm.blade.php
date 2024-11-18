@foreach($terms as $term)
    <ul class="children">
        <li id="term-{{ $term->id }}">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="in-term-{{ $term->id }}"
                       name="terms[{{ $term->taxonomy_id }}][]" value="{{ $term->id }}" @if(in_array($term->id, $selecteds)) checked @endif>
                <label class="custom-control-label"
                       for="in-term-{{ $term->id }}">{{ $term->name }}</label>
            </div>
        </li>
        @if(count($term->terms))
            @include('staff.product.subterm', ['terms' => $term->terms, 'selecteds' => $selecteds])
        @endif
    </ul>
@endforeach
