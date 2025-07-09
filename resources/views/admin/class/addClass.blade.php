<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    @include('./components/sidebar-admin')

    <div class="container card mt-3 mb-5" style="width:40%; height: 30%;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
            <a href="javascript:history.back()" class="btn btn-dark fw-bold">Back</a>
        </div>
        <h1 style="text-align:center;" class="mt-3 mb-3">Add Class</h1>
        <form method="post" action="{{ route('schoolClass.store') }}" class="mb-3">
            @csrf
            @if ($errors->has('duplicate'))
                <div class="alert alert-danger">
                    {{ $errors->first('duplicate') }}
                </div>
            @endif

            <div class="mb-3 mt-3">
                <label for="cname" class="form-label">Name Class</label>
                <select class="form-select" id="Name" name="name[]">
                    <option value="1st Grad">1st Grad</option>
                    <option value="2st Grad">2st Grad</option>
                    <option value="3st Grad">3st Grad</option>
                    <option value="4st Grad">4st Grad</option>
                    <option value="5st Grad">5st Grad</option>
                    <option value="6st Grad">6st Grad</option>
                    <option value="7st Grad">7st Grad</option>
                    <option value="8st Grad">8st Grad</option>
                    <option value="9st Grad">9st Grad</option>
                    <option value="10st Grad">10st Grad</option>
                    <option value="11st Grad">11st Grad</option>
                    <option value="12st Grad">12st Grad</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="section " class="form-label">Section</label>
                <select class="form-select" id="section" name="section[]">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
            <div class="d-grid gap-2 col-1 mx-auto ">
                <button type="submit" class="btn btn-primary justify-content-center" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
