@extends('layouts.app')

@section('content')

    <div class="container card mt-3 mb-5" style="width:40%">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Edit Teacher Details</h1>
        <form method="POST" action="{{ route('teacher.update', $teacher->id) }}" enctype="multipart/form-data">
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
                <input type="text" class="form-control" name="fname" value="{{ $teacher->user->name }}" />
            </div>
            <div class="mb-3 mt-3">
                <label for="email " class="form-label" @disabled(true)>Email</label>
                <input type="email" class="form-control" name="email" value="{{ $teacher->user->email }}" readonly/>

            </div>
            <div class="mb-3">
                <label for="qualification" class="form-label">Qualification</label>
                <input type="text" class="form-control " name="qualification" value="{{ $teacher->qualification }}" />
            </div>
            <div class="mb-3">
                <label for="subjects" class="form-label">Subjects</label>
                <select class="form-multi-select" name="subjects[]" multiple>
                    @foreach (['Hindi', 'Gujarati', 'English', 'Math', 'Computer','Science','Social Science'] as $subject)
                        <option value="{{ $subject }}" {{ in_array($subject, explode(', ', $teacher->subject)) ? 'selected' : '' }}>
                            {{ $subject }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="phoneno" class="form-label">Phone No.</label>
                <input type="text" class="form-control " name="phoneno" value="{{ $teacher->phone }}" />
                @error('phoneno')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="textArea" class="form-control " name="address" value="{{ $teacher->address }}" />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile Photo</label>
                <input type="file" class="form-control" name="photo" />
                @if ($teacher->profile_photo)
                    <img src="{{ asset('storage/' . $teacher->profile_photo) }}" width="100" class="mt-2" alt="Profile Image" />
                @endif

            </div>
            <div class="mb-3">
                <label for="joined_date" class="form-label">Join Date</label>
                <input type="date" class="form-control " name="joined_date" value="{{ $teacher->joined_date }}" />
            </div>

            <div class="d-grid gap-2 col-1 mx-auto  mb-3">
                <button type="submit" class="btn btn-primary justify-content-center" name="edit">Edit</button>
            </div>
        </form>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
    </div>
@endsection
