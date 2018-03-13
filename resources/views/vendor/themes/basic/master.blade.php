<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Basic Webcore Theme</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}">

    @yield('styles')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <!--Branding Image-->
                <a class="navbar-brand" href="#">Basic</a>
            </div>
        </div>
    </nav>

    <section class="container-fluid">
        <!-- Content Wrapper. Contains page content -->
        <div class="row">
            @yield('content')
        </div>
    </section>

    <!-- Javascript -->
    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('vendor/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('vendor/adminlte/plugins//bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>

    {{--<script src="{{ asset('js/app.js') }}"></script>--}}

    @yield('scripts')
</body>
</html>