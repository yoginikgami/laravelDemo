<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('./components/sidebar-admin')


    <div class="container mt-4" style="width:80%">
    <h2>📊 Admin Dashboard</h2>

    <div class="row mt-4">
        <!-- Total Teachers -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow-sm fw-bold text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Teachers</h5>
                    <p class="card-text fs-3">{{ $totalTeachers }}</p>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow-sm fw-bold text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text fs-3">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="col-md-4">
            <div class="card text-white bg-secondary mb-3 shadow-sm fw-bold text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text fs-3">{{ $totalClasses }}</p>
                </div>
            </div>
        </div>
    </div>

    {{--  <!-- Recent Registrations -->
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>🧑‍🏫 Recent Teachers</h4>
            <ul class="list-group">
                @forelse($recentTeachers as $teacher)
                    <li class="list-group-item">{{ $teacher->name }} ({{ $teacher->subject }})</li>
                @empty
                    <li class="list-group-item text-muted">No recent teachers</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-6">
            <h4>👩‍🎓 Recent Students</h4>
            <ul class="list-group">
                @forelse($recentStudents as $student)
                    <li class="list-group-item">{{ $student->fname }} (Roll No: {{ $student->roll_no }})</li>
                @empty
                    <li class="list-group-item text-muted">No recent students</li>
                @endforelse
            </ul>
        </div>
    </div>  --}}
</div>

</body>

</html>
