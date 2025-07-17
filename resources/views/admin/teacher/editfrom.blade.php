{{--  @extends('layouts.app')

@section('content')  --}}
<form method="POST" action="{{ route('teacher.update', $teacher->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="fname" value="{{ $teacher->user->name }}" />
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="{{ $teacher->user->email }}" disabled />
    </div>

    <div class="mb-3">
        <label class="form-label">Qualification</label>
        <input type="text" class="form-control" name="qualification" value="{{ $teacher->qualification }}" />
    </div>

    <div class="mb-3">
        <label class="form-label">Subjects</label>
        <select class="form-control" name="subjects[]" multiple>
            @foreach (['Hindi', 'Gujarati', 'English', 'Math', 'Computer', 'Science', 'Social Science'] as $subject)
                <option value="{{ $subject }}"
                    {{ in_array($subject, explode(', ', $teacher->subject)) ? 'selected' : '' }}>
                    {{ $subject }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phoneno" class="form-control" value="{{ $teacher->phone }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="{{ $teacher->address }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Photo</label>
        <input type="file" name="photo" class="form-control">
        @if ($teacher->profile_photo)
            <img src="{{ asset('storage/' . $teacher->profile_photo) }}" width="80" class="mt-2">
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Join Date</label>
        <input type="date" name="joined_date" class="form-control" value="{{ $teacher->joined_date }}">
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
{{--  @endsection  --}}

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.subject-multiselect').select2({
                placeholder: "Select subjects",
                width: '100%',
                allowClear: true
            });
        });
    </script>
@endpush
