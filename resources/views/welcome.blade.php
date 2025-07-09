<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
</head>
<body>
    <table class="table table-striped table-bordered" style="width: 100%">
        <tr>
        @foreach ($users as $user)
            <td>{{ $user->name}}</td>
            <td>{{ $user->email}}</td>
        @endforeach
        </tr>
    </table>
</body>
</html>
