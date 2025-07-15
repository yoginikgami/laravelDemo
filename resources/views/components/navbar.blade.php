<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid m-4">
            <a class="navbar-brand fw-bold fs-3" href="#">School Management</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="nav-link ">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                    {{--  <li>
                        <x-dropdown-link :href="route('profile.edit')" class="nav-link ">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                    </li>  --}}
            </div>

    </nav>
</body>

</html>
