@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if($items)
                    <div class="page-title">
                        <h3>{{ $items['page']['title'] }}</h3>
                    </div>

                    <div class="main-content">
                        {!! $items['page']['description'] !!}
                    </div>
                @else
                    <div class="main-content no-content">
                        <div class="page-title">
                            <h3>{{ $items['page']['slug'] }}</h3>
                        </div>

                        <div class="panel">
                            <div class="panel-body">
                                <h2>Tidak ada konten!</h2>
                                <p>Buat dan tulis konten halaman ini.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
@endsection