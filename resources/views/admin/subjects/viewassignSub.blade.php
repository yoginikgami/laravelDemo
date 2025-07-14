<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subject View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    @include('./components/side-bar')

    <div class="container card mt-3 mb-5" style="width:80%">
        <h1 style="text-align: center;" class="mt-3 mb-3"> Assign Subject List</h1>
        <a href="{{ route('subject.create')}}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%">Add Subject</a>
        <table class="table table-striped table-bordered" style="width: 100%">
            <tr>
                <th>Subject Name</th>
                <th>Class & Section</th>
                <th>Teacher Name</th>
                <th>Qualification</th>
                <th>Profile Photo</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
            @foreach ($subjcts as $subject)
            <tr>
                <td>{{$subject->name}}</td>
                <td>{{$subject->schoolClass->name}} - {{$subject->schoolClass->section}}</td>
                <td>{{$subject->teacher->user->name}}</td>
                <td>{{$subject->teacher->qualification}}</td>
                <td>
                    <img src="{{ asset('storage/' . $subject->teacher->profile_photo) }}" height="100px" width="100px" alt="Profile Photo">
                </td>

                <td><a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-success fw-bold">Edit</a></td>
                <td>
                    <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assign class and subject ?');">
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
