<h3>{{ $items->presentations[0]['component']['dataSource']['description'] }}</h3>

<div style="margin-bottom:15px">
  <span class="fa fa-calendar"></span> Filter
</div>

@foreach ($data as $item)
<div class="panel panel-default">
  <div class="panel-body">    
    @foreach ($item->toArray() as $val)
        <span>{{$val}}</span> |
    @endforeach
  </div>
</div>
@endforeach