<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.meta')
    <title>{{ config('app.name') }}</title>
    @include('layouts.styles')
</head>

<body class="hold-transition layout-fixed sidebar-mini sidebar-collapse tr">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('dist/img/logo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.navigation')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->
    @include('layouts.scripts')
</body>

</html>
