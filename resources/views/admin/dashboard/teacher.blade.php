<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('./components/sidebar-admin')
    <div class="container " style="width: 90%">
       <div class="row m-2 mt-5 gap-5 mx-auto">
            <div class="col-3 card bg-secondary text-white fw-bold text-center mt-3 mb-3">
                <h3 class="mt-3 mb-3">Total Teacher</h3>
                <h4>3</h4>
            </div>

            <div class="col-3 card bg-secondary text-white fw-bold text-center mt-3 mb-3">
                <h3 class="mt-3 mb-3">Total Student</h3>
                <h4>3</h4>
            </div>

            <div class="col-3 card bg-secondary text-white fw-bold text-center mt-3 mb-3">
                <h3 class="mt-3 mb-3">Total Class</h3>
                <h4>3</h4>
            </div>

       </div>
    </div>
</body>

</html>
