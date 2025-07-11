<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>

<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%; height: 50%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Assign Subject Edit</h1>
        <form method="POST" action="{{ route('subject.update', $subject->id) }}" class="mb-3"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->has('duplicate'))
                <div class="alert alert-danger">
                    {{ $errors->first('duplicate') }}
                </div>
            @endif

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" value="{{ $subject->name }}" readonly>
                <input type="hidden" name="name" value="{{ $subject->name }}">

            </div>

            <div class="mb-3">
                <select name="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $subject->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} {{ $class->section }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher</label>
                <select class="form-select" id="teacher_id" name="teacher_id" required>
                    <option value="">Select Teacher</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ $subject->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="d-grid gap-2 col-1 mx-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</body>

</html>
