<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:80%">
        <h1 style="text-align: center;" class="mt-3 mb-3"> Student Details</h1>
        <a href="{{ route('student.create')}}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%">Add Student</a>
        <table class="table table-striped table-bordered" style="width: 100%">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Roll No</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Profile Photo</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->schoolClass->name}} - {{ $student->schoolClass->section}}</td>
                <td>{{ $student->roll_no}}</td>
                <td>{{ $student->gender}}</td>
                <td>{{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</td>
                <td>
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" height="100" width="100">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $student->address}}</td>
                <td>{{ $student->contact_no}}</td>

                <td><a href="{{ route('student.edit', $student->id) }}" class="btn btn-success fw-bold">Edit</a></td>
                <td>
                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
    </div>
</body>
</html>
