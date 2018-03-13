<article class="col-sm-3" style="position:absolute;left:0;top:0">
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'basic/position/top_left_float')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</article>