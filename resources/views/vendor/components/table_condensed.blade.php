<h3>{{ $items['presentations'][0]['component']['data_source']['description'] }}</h3>

<div style="margin-bottom:15px">
  <span class="fa fa-calendar"></span> Filter
</div>

<div class="table-responsive">
  <table class="table table-condensed">
    @foreach ($data as $item)
      <tr>
        @foreach ($item->toArray() as $val)
          <td>{{$val}}</td>
        @endforeach
      </tr>
    @endforeach
  </table>
</div>