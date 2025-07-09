<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    @include('components.sidebar-admin')
    <div class='container' style="width:80%">
        <div class="card m-2">
            <div class="row m-3">
                <div class="card col-6 ">
                    <h5 class="card-title">Teacher</h5>
                    <a href="" class="btn btn-success btn-sm mt-4 mb-3" style="width:30%">Add Teacher</a>

                </div>
                <div class="card col-6">
                    <h5 class="card-title">Student</h5>
                    <a href="" class="btn btn-success btn-sm mt-4 mb-3" style="width:30%">Add Student</a>

                </div>
            </div>
            <div class="row m-3">
                <div class="card col-6">
                    <h5 class="card-title">Class</h5>
                    <a href="" class="btn btn-success btn-sm mt-4 mb-3" style="width:30%">Add Class</a>

                </div>
                <div class="card col-6">
                    <h5 class="card-title">Subject</h5>
                    <a href="" class="btn btn-success btn-sm mt-4 mb-3" style="width:30%">Add Subject</a>
                    
                </div>
            </div>
        </div>

    </div>
</body>
</html>
