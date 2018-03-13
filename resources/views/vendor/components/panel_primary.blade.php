<h3>{{ $items->presentations[0]['component']['dataSource']['description'] }}</h3>

<div style="margin-bottom:15px">
  <span class="fa fa-calendar"></span> Filter
</div>

@foreach ($data as $item)
<div class="panel panel-primary">
  <div class="panel-body" style="background-color:yellow">    
    @foreach ($item->toArray() as $val)
        <span>{{$val}}</span> |
    @endforeach
  </div>
</div>
@endforeach