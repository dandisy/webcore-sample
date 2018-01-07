@extends('themes::airlines.master')

@section('content')    
  <section id="content">    
    @include('themes::airlines.position.top')

    <div class="wrapper pad1">
      @include('themes::airlines.position.left')
      
      @include('themes::airlines.position.main_right')
    </div>
  </section>
@endsection