<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%; height: 80%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Add Student Details</h1>

        <form method="post" action="{{ route('student.store') }}" class="mb-3" enctype="multipart/form-data">

            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3 mt-3">
                <label for="fnamel" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fname" value="{{ old('fname')}} "required />
            </div>
            <div class="mb-3 mt-3">
                <label for="email " class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email')}} "required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control " name="password" required />
            </div>
            <div class="mb-3">
                <label for="confpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control " name="confpassword" required />
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Class </label>
                <select name="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach ($class as $classes)
                        <option value="{{ $classes->id}}">
                            {{ $classes->name}} {{ $classes->section ? ' - '. $classes->section : ''}}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="roll_no" class="form-label">Roll Number </label>
                <input type="text" class="form-control" name="roll_no" readonly required />
            </div>

            <div class="">
                <label for="gender" class="form-label">Gender</label>
            </div>
            <div class="mb-3">
                <input type="radio" class="form-check-input" name="gender" value="Male" checked>
                <label class="form-check-label" name="male" > Male</label>
                <input type="radio" class="form-check-input" name="gender" value="Female">
                <label class="form-check-label" name="female"> Female</label>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control " name="dob" required />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile photo</label>
                <input type="file" class="form-control " name="photo" required />
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control " name="address" value="{{ old('address')}} "required />
            </div>
            <div class="mb-3">
                <label for="contact_no" class="form-label">Phone No</label>
                <input type="text" class="form-control " name="contact_no" required />
            </div>

            <div class="d-grid gap-2 col-1 mx-auto ">
                <button type="submit" class="btn btn-primary justify-content-center" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<script>
    $(document).ready(function () {
        $('select[name="class_id"]').change(function () {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    url: '/get-roll-no',
                    type: 'GET',
                    data: { class_id: classId },
                    success: function (response) {
                        $('input[name="roll_no"]').val(response.next_roll);
                    }
                });
            } else {
                $('input[name="roll_no"]').val('');
            }
        });
    });
</script>
