<!-- Data Source Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data_source_id', 'Data Source Id:') !!}
    {!! Form::select('data_source_id', $datasource->pluck('name', 'id'), null, ['class' => 'form-control select2']) !!}
</div>

<!-- Parent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent', 'Parent:') !!}
    {!! Form::select('parent', $dataquery->pluck('id', 'id'), null, ['class' => 'form-control select2']) !!}
</div>

<!-- Command Field -->
<div class="form-group col-sm-6">
    {!! Form::label('command', 'Command:') !!}
    {!! Form::select('command', ['get' => 'get', 'first' => 'first', 'orderBy' => 'orderBy', 'orderByRaw' => 'orderByRaw', 'inRandomOrder' => 'inRandomOrder', 'latest' => 'latest', 'offset' => 'offset', 'limit' => 'limit', 'select' => 'select', 'addSelect' => 'addSelect', 'selectRaw' => 'selectRaw', 'where' => 'where', 'whereNull' => 'whereNull', 'whereNotNull' => 'whereNotNull', 'whereIn' => 'whereIn', 'whereNotIn' => 'whereNotIn', 'orWhere' => 'orWhere', 'whereBetween' => 'whereBetween', 'whereNotBetween' => 'whereNotBetween', 'whereDate' => 'whereDate', 'whereMonth' => 'whereMonth', 'whereDay' => 'whereDay', 'whereYear' => 'whereYear', 'whereTime' => 'whereTime', 'whereColumn' => 'whereColumn', 'whereExists' => 'whereExists', 'whereRaw' => 'whereRaw', 'join' => 'join', 'leftJoin' => 'leftJoin', 'on' => 'on', 'orOn' => 'orOn', 'groupBy' => 'groupBy', 'having' => 'having', 'havingRaw' => 'havingRaw', 'orHavingRaw' => 'orHavingRaw', 'count' => 'count', 'max' => 'max', 'avg' => 'avg', 'with' => 'with'], null, ['class' => 'form-control select2']) !!}
</div>

<!-- Column Field -->
<div class="form-group col-sm-6">
    {!! Form::label('column', 'Column:') !!}
    {!! Form::text('column', null, ['class' => 'form-control']) !!}
</div>

<!-- Operator Field -->
<div class="form-group col-sm-6">
    {!! Form::label('operator', 'Operator:') !!}
    {!! Form::select('operator', ['=' => '=', '>' => '>', '<' => '<', '>=' => '>=', '<=.!=' => '<=', 'NULL' => 'NULL', 'LIKE' => 'LIKE'], null, ['class' => 'form-control select2']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::textarea('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.dataQueries.index') !!}" class="btn btn-default">Cancel</a>
</div>
