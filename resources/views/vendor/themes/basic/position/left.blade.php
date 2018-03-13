<article class="col-sm-3">
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'basic/position/left')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</article>