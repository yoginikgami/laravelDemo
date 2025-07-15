<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SideBar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    {{--  @php
        $role = Auth::user();
        dd($role);
    @endphp  --}}
    {{--  <p>Role: {{ Auth::user()->getRoleNames()->implode(', ') }}</p>  --}}
    @include('components.navbar')

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
                <div
                    class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 ">
                    @role('Admin')
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">

                        <li>
                            <a href="{{ route('admin.admindashboard')}}" data-bs-toggle="collapse"
                            class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teacher.index') }}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Teacher</span></a>
                        </li>
                        <li>
                            <a href="{{ route('student.index') }}" data-bs-toggle="collapse"
                                class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span
                                    class="ms-1 d-none d-sm-inline">Student</span></a>
                        </li>
                        <li>
                            <a href="{{ route('schoolclass.index') }}" data-bs-toggle="collapse"
                                class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Class </span> </a>
                        </li>
                        <li>
                            <a href="{{ route('subject.index') }}" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Subject</span> </a>
                        </li>

                    </ul>
                    @endrole
                    @role('Teacher')


                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li>
                            <a href="{{ route('admin.teacherdashboard')}}" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span
                                    class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                        </li>
                        @can('manage student')
                        <li>
                            <a href="{{ route('student.index') }}" data-bs-toggle="collapse"
                                class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span
                                    class="ms-1 d-none d-sm-inline">Student</span></a>
                        </li>
                        @endcan

                    </ul>
                    @endrole
                    @role('Student')
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">

                        <li>
                            <a href="{{ route('admin.studentDashboard') }}" data-bs-toggle="collapse"
                                class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span
                                    class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                        </li>
                    </ul>
                    @endrole

                </div>
            </div>
</body>

</html>
