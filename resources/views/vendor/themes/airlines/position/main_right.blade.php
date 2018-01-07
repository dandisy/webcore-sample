<article class="col2">
    @foreach (@$items['presentations'] as $item)
        @if($item['position'] === 'main_right')
            @include('components.'.$item['component'])
        @endif
    @endforeach
</article>