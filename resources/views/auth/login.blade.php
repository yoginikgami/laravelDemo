<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login From</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    @include('components.navbar')
    <div class="container">
        <div class="card m-5 " style="width: 25rem;">
            <div class="card-header fw-bold fs-1">
                Login
            </div>
            <div class="card-body">

                <form action="" method="GET">
                    @csrf

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label"> Email Address</label>
                        <input type="text"
                            class="form-control @error('email') is-invalid @enderror" name="email" />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" />
                    </div>

                    <button class="btn btn-primary " value="submit">Submit</button>
                    <a href="#" class="btn btn-success w-10">Register</a>
                </form>
                @if ($errors->any())
                  <div class="card-footer text-body-secondary">
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li></li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                @endif
            </div>

        </div>
    </div>
</body>
</html>
