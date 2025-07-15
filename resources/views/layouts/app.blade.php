<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">

    <!-- Optional: Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/css/coreui.min.css" rel="stylesheet">


    <!-- Your Custom Styles (if any) -->
    @stack('styles')
</head>
<body class="bg-light">


    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            @include('components.side-bar')

            {{-- Main Content --}}
            <main class="col ps-md-3 pt-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-bmbxuPwQa2lc/FvnE3vrJbKc7E+Kp3rNZo8h+gka9Ykkt0Zt2GYSkH/WeI5z9jvK"
        crossorigin="anonymous"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/js/coreui.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
