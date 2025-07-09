<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Addteacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Choices.js CSS -->
    {{--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />  --}}
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/css/coreui.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/js/coreui.bundle.min.js"></script>

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Add Teacher Details</h1>

        <form method="POST" action="{{ route('teacher.store') }} " enctype="multipart/form-data">
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
                <input type="text" class="form-control" name="fname" value="{{ old('fname')}} " required />
            </div>
            <div class="mb-3 mt-3">
                <label for="email " class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email')}} " required />
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
                <label for="qualification" class="form-label">Qualification</label>
                <input type="text" class="form-control " name="qualification" value="{{ old('qualification')}} " required />
            </div>


            <div class="mb-3">
                <label for="subjects" class="form-label">Subjects</label>
                <select class="form-multi-select" id="subjects" name="subjects[]"  multiple required>
                    <option value="Hindi">Hindi</option>
                    <option value="Gujarati">Gujarati</option>
                    <option value="English">English</option>
                    <option value="Math">Math</option>
                    <option value="Computer">Computer</option>
                    <option value="Science">Science</option>
                    <option value="Social Science">Social Science</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="phoneno" class="form-label">Phone No.</label>
                <input type="text" class="form-control " name="phoneno" value="{{ old('phoneno')}} " required />
                @error('phoneno')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="textArea" class="form-control " name="address" value="{{ old('address')}} " required />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile photo</label>
                <input type="file" class="form-control " name="photo" required />
            </div>
            <div class="mb-3">
                <label for="joined_date" class="form-label">Join Date</label>
                <input type="date" class="form-control " name="joined_date" value="{{Carbon\Carbon::parse(old('to_date'))->format('mm/dd/yyyy')}} " required />
            </div>

            <div class="d-grid gap-2 col-1 mx-auto ">
                <button type="submit" class="btn btn-primary justify-content-center" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
