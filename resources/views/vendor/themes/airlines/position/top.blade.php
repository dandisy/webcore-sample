<div class="for_banners">
    @include('themes::airlines.position.top_left_float')
    
    @foreach (@$items['presentations'] as $item)
        @if($item['position'] === 'top')
            @include('components.'.$item['component'])
        @endif
    @endforeach
</div>