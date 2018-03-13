<article class="col1">
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'airlines/position/top_left_float')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</article>