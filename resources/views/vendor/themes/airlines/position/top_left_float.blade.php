<article class="col1">
    @foreach (@$items['presentations'] as $item)
        @if($item['position'] === 'top_left_float')
            @include('components.'.$item['component'])
        @endif
    @endforeach
</article>