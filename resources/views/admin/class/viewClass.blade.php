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
        <h1 style="text-align: center;" class="mt-3 mb-3"> Class</h1>
        <a href="{{ route('schoolClass.create')}}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%;">Add Class</a>
        <table class="table table-striped table-bordered" style="width: 90%">
            <tr>
                <th>Class</th>
                <th>Section</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
                @foreach ($schoolClass as $class)
                <tr>
                    <td>{{ $class->name}}</td>
                    <td>{{ $class->section}}</td>
                    <td><a href="{{ route('schoolClass.edit', $class->id)}}" class="btn btn-success fw-bold">Edit</a></td>
                    <td>
                    <form action="{{ route('schoolClass.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
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
