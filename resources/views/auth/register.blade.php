<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>

    @include('components.navbar')

    <div class="container">
        <div class="card m-5" style="width: 25rem;">
            <div class="card-header fw-bold fs-1">
                Register
            </div>
            <div class="card-body">

                <form action="" method="POST">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label"> Name</label>
                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror" name="name" />
                    </div>
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
                    <div class="mb-3 mt-3">
                        <label for="confirmpass" class="form-label">Confirm Password</label>
                        <input type="password"
                            class="form-control @error('confirmpass') is-invalid @enderror" name="password_confirmation" />
                    </div>

                    <button class="btn btn-primary btn-sm" value="submit">Submit</button>
                    <a href="" class="btn btn-dark">Back</a>
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
