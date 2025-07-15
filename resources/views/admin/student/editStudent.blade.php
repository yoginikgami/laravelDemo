@extends('layouts.app')

@section('content')


    <div class="container card mt-3 mb-5" style="width:50%; ">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Edit Student Details</h1>
        <form method="post" action="{{ route('student.update', $student->id) }}" class="mb-3" enctype="multipart/form-data">

            @csrf
            @method('PUT')
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
                <input type="text" class="form-control" name="fname" value="{{ $student->user->name}} "required />
            </div>
            <div class="mb-3 mt-3">
                <label for="email " class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $student->user->email}} "required />
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Class </label>
                <select name="class_id" class="form-select" required>
                    <option value="{{ $student->schoolClass->id}}">Select Class</option>
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
                <input type="text" class="form-control" name="roll_no" value="{{ $student->roll_no}}" readonly required />
            </div>

            <div class="">
                <label for="gender" class="form-label">Gender</label>
            </div>
            <div class="mb-3">
                <input type="radio" class="form-check-input" name="gender" value="Male"
                    {{ old('gender', $student->gender) == 'Male' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_male">Male</label>

                <input type="radio" class="form-check-input ms-3" name="gender" value="Female"
                    {{ old('gender', $student->gender) == 'Female' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_female">Female</label>
            </div>

            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control " name="dob" value="{{ $student->dob }}" />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile Photo</label>
                <input type="file" class="form-control" name="photo" />
                @if ($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" width="100" class="mt-2" alt="Photo" />
                @endif
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control " name="address" value="{{ $student->address}} " />
            </div>
            <div class="mb-3">
                <label for="contact_no" class="form-label">Phone No</label>
                <input type="text" class="form-control " name="contact_no" value="{{ $student->contact_no}}" />
            </div>

            <div class="d-grid gap-2 col-1 mx-auto ">
                <button type="submit" class="btn btn-primary justify-content-center" name="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection
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
