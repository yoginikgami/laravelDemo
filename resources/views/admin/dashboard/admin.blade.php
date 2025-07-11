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
        <div class="row">
            <div class="col-3 card m-3">
                <h3 class="mt-3 fw-bold" style="text-align: center">Profile</h3>
                @if ($teacher)
                    <div class="text-center">
                        <label for="photoInput">
                            <img id="photoPreview" src="{{ asset('storage/' . $teacher->profile_photo) }}"
                                width="100" class="mt-2 rounded border border-secondary" alt="Profile Image"
                                style="cursor: pointer;" />
                        </label>
                        <form method="POST" action="{{ route('teacher.updatePhoto', $teacher->id) }}"
                            enctype="multipart/form-data" class="mt-3">
                            @csrf
                            @method('PUT')

                            <input type="file" id="photoInput" name="photo" class="form-control d-none"
                                accept="image/*" onchange="previewImage(event)">

                            <div id="previewControls" class="mt-3 d-none">
                                <button type="submit" class="btn btn-success fw-bold me-2">Update Photo</button>
                                <button type="button" class="btn btn-secondary fw-bold"
                                    onclick="resetPreview()">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-3 mt-3 ">
                        <label for="fnamel" class="form-label">Name</label>
                        <input type="text" class="form-control" name="fname" value="{{ $teacher->user->name }} "
                            @disabled(true) />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email " class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $teacher->user->email }} "
                            @disabled(true) />
                    </div>

                    <form method="POST" action="{{ route('dashboardupdate', $teacher->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 mt-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $teacher->address }}"
                                required />
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contact_no" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_no" value="{{ $teacher->phone }}"
                                required maxlength="10" minlength="10" />
                        </div>
                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary fw-bold">Update Info</button>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                @else
                    <p>teacher not found</p>
                @endif
            </div>
            <div class="col-8 card m-3">
                <h3 class="mt-3 fw-bold" style="text-align: center">Student Count per Class</h3>
                <table class="table table-striped mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Total Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentCountsByClass as $class)
                            <tr>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->section }}</td>
                                <td><span class=" fs-6">{{ $class->student_count }}</span></td>
                            </tr>
                        @endforeach
                        @if ($studentCountsByClass->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-muted">No students found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photoPreview').src = e.target.result;
                document.getElementById('previewControls').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }

    function resetPreview() {
        const preview = document.getElementById('photoPreview');
        const fileInput = document.getElementById('photoInput');

        preview.src = "{{ asset('storage/' . $teacher->photo) }}";

        document.getElementById('previewControls').classList.add('d-none');

        fileInput.value = "";
    }
</script>
