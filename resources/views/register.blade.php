<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register/Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand btn btn-success text-white btn-lg" href="{{ url('/') }}">Back</a>
        </nav>
    </div>
    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-md-6">
                @if (session('status'))
                    <h6 class="alert alert-success">{{ session('status') }}</h6>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Form</h3>
                    </div>
                    <div class="card-body">
                        @if (isset($register))
                            <form method="post" action="{{ url('update/' . $register->reg_id) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="container">
                            <div class="form-group my-4">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $register->name ?? '') }}" placeholder="Full Name">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group my-4">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('name', $register->email ?? '') }}" placeholder="Email">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="row">
                                <label for="" class="mb-2">Choose Gender</label>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="gender" value="M"
                                            checked>MALE
                                        <label class="form-check-label" for="radio1"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="gender"
                                            value="F">FEMALE
                                        <label class="form-check-label" for="radio2"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="gender"
                                            value="O">OTHERS
                                        <label class="form-check-label" for="radio2"></label>
                                    </div>
                                </div>
                                <span class="text-danger">
                                    @error('gender')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <select class="form-select mt-3" name="country">
                                    <option value="India">India</option>
                                    <option value="USA">USA</option>
                                    <option value="UK">UK</option>
                                    <option value="Canada">Canada</option>
                                </select>
                                <span class="text-danger">
                                    @error('country')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="row my-3">
                                <label for="" class="my-2">Choose Qualification</label>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="quali[]" value="1">
                                        <label class="form-check-label" for="check1">10th</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="quali[]" value="2">
                                        <label class="form-check-label" for="check2">12th</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="quali[]" value="3">
                                        <label class="form-check-label" for="check3">UG</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="quali[]"
                                            value="4">
                                        <label class="form-check-label" for="check4">PG</label>
                                    </div>
                                </div>
                                <span class="text-danger">
                                    @error('quali')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group my-4">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    value="{{ old('password') }}">
                                <span class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group my-4">
                                <label for="">Confirm Password</label>
                                <input type="password" name="cpassword" class="form-control"
                                    placeholder="Confirm Password" value="{{ old('password') }}">
                                <span class="text-danger">
                                    @error('cpassword')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Choose Image</label>
                                <input class="form-control" type="file" name="image" />
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary my-4">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
