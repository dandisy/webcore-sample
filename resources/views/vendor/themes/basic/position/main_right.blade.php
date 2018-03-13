<article class="col-sm-9">
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'basic/position/main_right')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</article>