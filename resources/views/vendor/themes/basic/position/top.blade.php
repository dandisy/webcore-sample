<div class="top-content" style="position:relative">
    @include('themes::basic.position.top_left_float')
    
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'basic/position/top')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</div>