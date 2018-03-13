<!-- Page Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('page_id', 'Page Id:') !!}
    {!! Form::select('page_id', $page->pluck('title', 'id'), null, ['class' => 'form-control select2']) !!}
</div>

<!-- Media Field -->
<div class="form-group col-sm-6">
    {!! Form::label('media', 'Media:') !!}
    {!! Form::select('media', ['Desktop' => 'Desktop', 'Mobile' => 'Mobile'], null, ['class' => 'form-control select2']) !!}
</div>

<!-- Component Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('component_id', 'Component Id:') !!}
    {!! Form::select('component_id', $component->pluck('name', 'id'), null, ['class' => 'form-control select2']) !!}
</div>

<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('position', 'Position:') !!}
    {!! Form::select('position', $themes, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order', 'Order:') !!}
    {!! Form::number('order', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.presentations.index') !!}" class="btn btn-default">Cancel</a>
</div>
