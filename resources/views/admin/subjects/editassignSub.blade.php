<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Addteacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/css/coreui.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.15.0/dist/js/coreui.bundle.min.js"></script>

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%; height: 50%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align: center;" class="mt-3 mb-3">Assign Subject Edit</h1>
        <form method="POST" action="" class="mb-3" enctype="multipart/form-data">
    @csrf

    {{-- Select Subject --}}
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

    {{-- Select Class --}}
    <div class="mb-3">
        <label for="class_id" class="form-label">Class</label>
        <select name="class_id" class="form-select" required>
            <option value="">Select Class</option>
        </select>
    </div>

    {{-- Select Teacher (Dynamic) --}}
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
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                }
            });
        } else {
            $('#teacher_id').html('<option value="">Select Subject First</option>');
        }
    });
</script>
