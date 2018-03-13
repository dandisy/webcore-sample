<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- View Field -->
<div class="form-group col-sm-6">
    {!! Form::label('view', 'View:') !!}
    {!! Form::select('view', $components, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('source', 'Source:') !!}
    {!! Form::select('source', ['DataField' => 'DataField', 'DataSource' => 'DataSource'], null, ['class' => 'form-control select2']) !!}
</div>

<!-- Data Source Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data_source_id', 'Data Source Id:') !!}
    {!! Form::select('data_source_id', $datasource->pluck('name', 'id'), null, ['class' => 'form-control select2']) !!}
</div>

<!-- Data Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data', 'Data:') !!}
    {!! Form::text('data', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.components.index') !!}" class="btn btn-default">Cancel</a>
</div>
