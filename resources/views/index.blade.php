@php
    function qualiarr($value)
    {
        if ($value == '1') {
            return '10th';
        } elseif ($value == '2') {
            return '12th';
        } elseif ($value == '3') {
            return 'UG';
        } elseif ($value == '4') {
            return 'PG';
        } else {
            return '';
        }
    }
    function arrf($value)
    {
        if ($value == 'M') {
            return 'Male';
        } elseif ($value == 'F') {
            return 'Female';
        } else {
            return 'Others';
        }
    }
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand btn btn-success text-white btn-lg" href="{{ url('register') }}">Insert</a>
        </nav>
    </div>
    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List of All Users</h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Country</th>
                                    <th>Qualification</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->reg_id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @php
                                                echo arrf($item->gender);
                                            @endphp
                                        </td>
                                        <td>{{ $item->country }}</td>
                                        <td>@php $arr = explode(',',$item->quali);@endphp
                                            @foreach ($arr as $value)
                                                @php
                                                    echo qualiarr($value);
                                                @endphp
                                            @endforeach
                                        </td>
                                        <td><img src='{{ asset('images/' . $item->image) }}' width="70px"
                                                height="70px"></td>
                                        <td>
                                            <a href="{{ url('edit/' . $item->reg_id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('delete/' . $item->reg_id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
