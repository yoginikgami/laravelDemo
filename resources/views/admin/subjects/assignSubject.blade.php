@extends('layouts.app')

@section('content')
    <div class="container card mt-3 mb-5" style="width:40%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Assign Subject</h1>

        <form method="POST" action="{{ route('subject.store') }}">
            @csrf

            @if ($errors->has('duplicate'))
                <div class="alert alert-danger">{{ $errors->first('duplicate') }}</div>
            @endif

            {{-- Subject --}}
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <select class="form-select" id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                    <option value="Hindi">Hindi</option>
                    <option value="Gujarati">Gujarati</option>
                    <option value="English">English</option>
                    <option value="Math">Math</option>
                    <option value="Computer">Computer</option>
                    <option value="Science">Science</option>
                    <option value="Social Science">Social Science</option>
                </select>
            </div>

            {{-- Class --}}
            <div class="mb-3">
                <label for="class_id" class="form-label">Class</label>
                <select name="class_id[]" class="form-multi-select" multiple required>

                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Teacher --}}
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher</label>
                <select class="form-select" id="teacher_id" name="teacher_id" required>
                    <option value="">Select Subject First</option>
                </select>
            </div>

            <div class="d-grid gap-2 col-1 mx-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

{{-- Pushing script --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#subject').change(function () {
            var subject = $(this).val();

            if (subject !== '') {
                $.ajax({
                    url: "{{ route('teachers.by.subject') }}",
                    type: "GET",
                    data: { subject: subject },
                    success: function (data) {
                        let options = '<option value="">Select Teacher</option>';
                        data.forEach(function (teacher) {
                            options += `<option value="${teacher.id}">${teacher.name}</option>`;
                        });
                        $('#teacher_id').html(options);
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            } else {
                $('#teacher_id').html('<option value="">Select Subject First</option>');
            }
        });
    });
</script>
@endpush
