@if($display === 'toArray')
    @if($key and isset($items[$key]))
        {{dd($items[$key]->toArray())}}
    @else
        {{dd($items->toArray())}}
    @endif
@else
    @if($key and isset($items[$key]))
        {{dd($items[$key])}}
    @else
        {{dd($items)}}
    @endif
@endif

<pre>
@if($display === 'print_r')
    @if($key and isset($items[$key]))
        {{print_r($items[$key])}}
    @else
        {{print_r($items)}}
    @endif
@elseif($display === 'var_dump')
    @if($key and isset($items[$key]))
        {{var_dump($items[$key])}}
    @else
        {{var_dump($items)}}
    @endif
@elseif($display === 'var_export')
    @if($key and isset($items[$key]))
        {{var_export($items[$key])}}
    @else
        {{var_export($items)}}
    @endif
@endif
</pre>