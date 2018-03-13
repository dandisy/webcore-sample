@extends('themes::basic.master')

@section('content')
    @if($items['page']['presentations'])
        <div class="col-sm-12">
            @include('themes::basic.position.top')
        </div>

        @include('themes::basic.position.left')

        @include('themes::basic.position.main_right')

        <div class="col-sm-12">
            @include('themes::basic.position.main')
        </div>
    @else
        <div class="col-sm-12">
            @include('themes::basic.position.widgets.top')
        </div>

        @include('themes::basic.position.widgets.left')

        <div class="col-sm-12">
            @include('themes::basic.position.widgets.main')
        </div>

        @include('themes::basic.position.widgets.right')

        <div class="col-sm-12">
            @include('themes::basic.position.widgets.bottom')
        </div>
    @endif
@endsection