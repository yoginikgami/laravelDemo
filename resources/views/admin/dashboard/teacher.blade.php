<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('components.side-bar')
    <div class="container mt-4" style="width: 80%">
        <h5 class="card-title"> 👩‍🏫 Welcome, {{ $user->name }}</h5>
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
                            enctype="multipart/form-data">

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
                        <script>
                            setTimeout(function() {
                                const alert = document.getElementById('success-alert');
                                if (alert) {
                                    alert.style.transition = 'opacity 0.5s ease';
                                    alert.style.opacity = '0';
                                    setTimeout(() => alert.remove(), 500);
                                }
                            }, 3000);
                        </script>
                    @endif
                @else
                    <p>teacher not found</p>
                @endif
            </div>
            <div class="col-8 card m-3">
                @if ($assignedSubjects->isNotEmpty())
                    <div class="card mt-4">
                        <div class="card-header fw-bold">📚 Assigned Classes & Subjects</div>
                        <ul class="list-group list-group-flush">
                            @foreach ($assignedSubjects as $assignment)
                                <li class="list-group-item">
                                    Class:
                                    <strong>
                                        {{ optional($assignment->schoolClass)->name ?? 'N/A' }}
                                        {{ optional($assignment->schoolClass)->section ?? '' }}
                                    </strong>
                                    <br>
                                    Subject: <strong>{{ $assignment->name }}</strong>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                @else
                    <div class="alert alert-warning mt-4">No classes or subjects assigned yet.</div>
                @endif


                @if ($assignedSubjects->isNotEmpty())
                    <div class="card mt-4">
                        <div class="card-header fw-bold">📚 Assigned Classes, Subjects & Students</div>
                        <ul class="list-group list-group-flush">
                            @foreach ($assignedSubjects as $assignment)
                                <li class="list-group-item">
                                    <strong>Class:</strong>
                                    {{ optional($assignment->schoolClass)->name ?? 'N/A' }}
                                    {{ optional($assignment->schoolClass)->section ?? '' }}<br>

                                    <strong>Subject:</strong> {{ $assignment->name }}

                                    @php
                                        $students = $studentsByClass[$assignment->class_id] ?? collect();
                                    @endphp

                                    @if ($students->isNotEmpty())
                                        <ul class="mt-2">
                                            @foreach ($students as $student)
                                                <li>
                                                    {{ $student->roll_no }} -
                                                    Name: {{ $student->user->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-muted mt-2">No students found in this class.</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="alert alert-warning mt-4">No classes or subjects assigned yet.</div>
                @endif
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
