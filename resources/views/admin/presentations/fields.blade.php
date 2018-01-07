<!-- Component Field -->
<div class="form-group col-sm-6">
    {!! Form::label('component', 'Component:') !!}
    {!! Form::text('component', null, ['class' => 'form-control']) !!}
</div>

<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('position', 'Position:') !!}
    {!! Form::text('position', null, ['class' => 'form-control']) !!}
</div>

<!-- Datasource Field -->
<div class="form-group col-sm-6">
    {!! Form::label('datasource', 'Datasource:') !!}
    {!! Form::text('datasource', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order', 'Order:') !!}
    {!! Form::number('order', null, ['class' => 'form-control']) !!}
</div>

<!-- Page Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('page_id', 'Page Id:') !!}
    {!! Form::number('page_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.presentations.index') !!}" class="btn btn-default">Cancel</a>
</div>
