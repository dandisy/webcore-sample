<div class="for_banners">
    @include('themes::airlines.position.top_left_float')
    
    @foreach (@$items['page']['presentations'] as $item)
        @if($item['position'] === 'airlines/position/top')
            @include('vendor.components.'.$item['component']['view'])
        @endif
    @endforeach
</div>