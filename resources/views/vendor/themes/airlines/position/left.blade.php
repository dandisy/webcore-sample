<article class="col1">
    @foreach (@$items['presentations'] as $item)
        @if($item['position'] === 'left')
            @include('components.'.$item['component'])
        @endif
    @endforeach
</article>