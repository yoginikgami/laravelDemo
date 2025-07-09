<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%; height: 30%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align:center;" class="mt-3 mb-3">Edit Class</h1>
        <form method="post" action="{{ route('schoolClass.update',$schoolClass->id)}}" class="mb-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')
           @if ($errors->has('duplicate'))
                <div class="alert alert-danger">
                    {{ $errors->first('duplicate') }}
                </div>
            @endif

            <div class="mb-3 mt-3">
                <label for="cname" class="form-label">Name Class</label>
                <select class="form-select" id="Name" name="name">
                    <option value="1st Grad" {{ $schoolClass->name == '1st Grad' ? 'selected' : '' }}>1st Grad</option>
                    <option value="2st Grad" {{ $schoolClass->name == '2st Grad' ? 'selected' : '' }}>2st Grad</option>
                    <option value="3st Grad" {{ $schoolClass->name == '3st Grad' ? 'selected' : '' }}>3st Grad</option>
                    <option value="4st Grad" {{ $schoolClass->name == '4st Grad' ? 'selected' : '' }}>4st Grad</option>
                    <option value="5st Grad" {{ $schoolClass->name == '5st Grad' ? 'selected' : '' }}>5st Grad</option>
                    <option value="6st Grad" {{ $schoolClass->name == '6st Grad' ? 'selected' : '' }}>6st Grad</option>
                    <option value="7st Grad" {{ $schoolClass->name == '7st Grad' ? 'selected' : '' }}>7st Grad</option>
                    <option value="8st Grad" {{ $schoolClass->name == '8st Grad' ? 'selected' : '' }}>8st Grad</option>
                    <option value="9st Grad" {{ $schoolClass->name == '9st Grad' ? 'selected' : '' }}>9st Grad</option>
                    <option value="10st Grad" {{ $schoolClass->name == '10st Grad' ? 'selected' : '' }}>10st Grad</option>
                    <option value="11st Grad" {{ $schoolClass->name == '11st Grad' ? 'selected' : '' }}>11st Grad</option>
                    <option value="12st Grad" {{ $schoolClass->name == '12st Grad' ? 'selected' : '' }}>12st Grad</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="section " class="form-label">Section</label>
                <select class="form-select" id="section" name="section">
                    <option value="A" {{ $schoolClass->section == 'A' ? 'selected' : ''}}>A</option>
                    <option value="B" {{ $schoolClass->section == 'B' ? 'selected' : ''}}>B</option>
                    <option value="C" {{ $schoolClass->section == 'C' ? 'selected' : ''}}>C</option>
                    <option value="D" {{ $schoolClass->section == 'D' ? 'selected' : ''}}>D</option>
                    <option value="E" {{ $schoolClass->section == 'E' ? 'selected' : ''}}>E</option>
                </select>
            </div>
            <div class="d-grid gap-2 col-1 mx-auto ">
                <button type="submit" class="btn btn-primary justify-content-center" name="edit">Edit</button>
            </div>
        </form>
    </div>
</body>
</html>
