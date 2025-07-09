<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Addteacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:80%">
        <h1 style="text-align: center;" class="mt-3 mb-3"> Teacher Details</h1>
        <a href="{{ route('teacher.create') }}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%">Add Teacher</a>
        <table class="table table-striped table-bordered" style="width: 100%">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Qualification</th>
                <th>Subjects</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Profile Photo</th>
                <th>Join Date</th>
                <th>View</th>
                <th>Delete</th>
            </tr>

            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->user->name }}</td>
                <td>{{ $teacher->user->email }}</td>
                <td>{{ $teacher->qualification }}</td>
                <td>{{ $teacher->subject }}</td>
                <td>{{ $teacher->phone }}</td>
                <td>{{ $teacher->address }}</td>
                <td>
                    @if($teacher->profile_photo)
                        <img src="{{ asset('storage/' . $teacher->profile_photo) }}" height="100" width="100">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($teacher->joined_date)->format('d/m/Y') }}</td>
                <td><a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-success fw-bold">Edit</a></td>
                <td>
                    <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                    </form>
                </td>

                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
