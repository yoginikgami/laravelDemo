@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="row">
        <div class="col-3 card">
            <h3 class="mt-3 text-center">Profile</h3>
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
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{ $student->user->name }}" disabled />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $student->user->email }}" disabled />
                </div>
                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <input type="text" class="form-control"
                        value="{{ $student->schoolclass->name }} - {{ $student->schoolclass->section }}" disabled />
                </div>

                <form method="POST" action=" ">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 mt-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ $student->address }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="contact_no"
                            value="{{ $student->contact_no }}" required maxlength="10" minlength="10" />
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold">Update Info</button>
                </form>

                @if (session('success'))
                    <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
                @endif
            @else
                <p>Student not found</p>
            @endif
        </div>

        <div class="col-8">
            <div class="card mb-3">
                <h3 class="m-3 text-center">{{ $student->schoolclass->name }} - {{ $student->schoolclass->section }}</h3>
                <label class="form-label m-3 fw-bold">Subjects & Teachers</label>
                <ul class="list-group m-3">
                    @forelse($subjects as $subject)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $subject->name }}
                            <span class="badge bg-primary fw-bold fs-6" style="width: 150px;">
                                {{ $subject->teacher->user->name ?? 'No Teacher Assigned' }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item">No subjects assigned to this class.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
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
@endpush
