@foreach (@$items['page']['presentations'] as $item)
    @if($item['position'] === 'basic/position/main')
        @include('vendor.components.'.$item['component']['view'])
    @endif
@endforeach