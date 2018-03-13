<article class="col2">
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'airlines/position/main_right')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</article>