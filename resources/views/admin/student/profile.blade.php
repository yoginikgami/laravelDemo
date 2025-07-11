<!DOCTYPE html>
<html lang="en">
/home/wrteam/schoolMan/resources/views/admin/student/profile.blade.php
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    @include('./components/sidebar-student')
    <div class="container mt-4" style="width:80%; align-items: center;">
            <div class="col-3 card ">
                <h3 class="mt-3" style="text-align: center">Profile</h3>
                @if ($student)
                    <div class="text-center">
                        <label for="photoInput">
                            <img id="photoPreview" src="{{ asset('storage/' . $student->photo) }}" width="100"
                                class="mt-2 rounded border border-secondary" alt="Profile Image"
                                style="cursor: pointer;" />
                        </label>
                        <form method="POST" action="{{ route('student.updatePhoto', $student->id) }}"
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

                    <div class="mb-3 mt-3">
                        <label for="fnamel" class="form-label">Name</label>
                        <input type="text" class="form-control" name="fname" value="{{ $student->user->name }} "
                            @disabled(true) />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email " class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $student->user->email }} "
                            @disabled(true) />
                    </div>
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class </label>
                        <input type="text" class="form-control" name="class"
                            value="{{ $student->schoolclass->name }} - {{ $student->schoolclass->section }}"
                            @disabled(true)>
                    </div>
                @endif
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

        preview.src = "{{ asset('storage/' . $student->photo) }}";

        document.getElementById('previewControls').classList.add('d-none');

        fileInput.value = "";
    }
</script>
