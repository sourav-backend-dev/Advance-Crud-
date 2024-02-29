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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajax Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body class="d-flex flex-column h-100">
    <!-- Begin page content -->
    <main>
        <div class="container" style="padding: 60px 15px 0;">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add-project-modal">Add Project</a>
                    {{-- dropdown button for sorting  --}}
                    <select id="sort" class="btn btn-warning">
                        <option value="none" selected disabled hidden>SORT DATA</option>
                        <option value="0">AESC</option>
                        <option value="1">DESC</option>
                    </select>


                    {{-- Filters in Quali,Gender,Country  --}}
                    <div id="filter" class="bg-info py-2 text-center my-2">
                        <strong class="mx-3">GENDER</strong>
                        @php $arr = explode(',',$filter->gender);@endphp
                        @foreach ($arr as $value)
                            <input type="checkbox" class="form-check-input" name="gender" value={{ $value }}
                                id="checkbox">@php echo arrf($value); @endphp </input>
                        @endforeach
                        <strong class="mx-3">COUNTRY</strong>
                        @php $arr = explode(',',$filter->country);@endphp
                        @foreach ($arr as $value)
                            <input type="checkbox" class="form-check-input" name="country" value={{ $value }}
                                id="checkbox">@php echo ($value); @endphp </input>
                        @endforeach
                        <strong class="mx-3">QUALIFICATION</strong>
                        @php $arr = explode(',',$filter->quali);@endphp
                        @foreach ($arr as $value)
                            <input type="checkbox" class="form-check-input" name="quali" value={{ $value }}
                                id="checkbox">@php echo qualiarr($value); @endphp </input>
                        @endforeach
                        <button id="filterbtn" type="submit" class="btn btn-success mx-3">Filter</button>
                    </div>

                    {{-- search bar to filter the data  --}}
                    <div style="display: flex;  justify-content: flex-end;" class="my-3">
                        <input type="text" placeholder="Search By Title" id="myInput">
                    </div>

                </div>

                <div class="card-body">
                    <div class="delmsg"></div>
                    <table class="table table-bordered table-striped" id="projects-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Email</th>
                                <th>country</th>
                                <th>quali</th>
                                <th>gender</th>
                                <th>Image</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($projects as $project)
                                <tr id="idrow">
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->email }}</td>
                                    <td>{{ $project->country }}</td>
                                    <td id="quali">@php $arr = explode(',',$project->quali);@endphp
                                        @foreach ($arr as $value)
                                            @php
                                                echo qualiarr($value);
                                            @endphp
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            echo arrf($project->gender);
                                        @endphp
                                    </td>
                                    <td><img src="{{ asset('images/' . $project->image) }}" height="70px"
                                            width="70px"></td>
                                    <td><button class="deleteRecord btn  btn-sm btn-danger "
                                            data-id="{{ $project->id }}">Delete</button></td>
                                    <td><button class="editRecord btn  btn-sm btn-secondary "
                                            data-id="{{ $project->id }}">Edit</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <card-footer>
                    <div class="container my-3">
                        <div class="row justify-content-center">
                            @for ($i = 0; $i < $count; $i++)
                                <div class="col-md-2">
                                    <input type="button" class="btn btn-secondary mb-5" id="pagenumber"
                                        value={{ $i + 1 }}>
                                </div>
                            @endfor
                        </div>
                    </div>
                </card-footer>
            </div>
        </div>
    </main>

    <!-- The Modal -->
    <div class="modal" id="add-project-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Project</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="msg"></div>
                <form data-action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"
                    id="add-project-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="page" value={{ $count }}>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Title"
                                name="title">
                            <span id="title-error" class="text-danger"></span>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" placeholder="Description"
                                name="description">
                            <span id="desc-error" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email"
                                name="email">
                            <span id="email-error" class="text-danger"></span>
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
                            <span id="gender-error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <select class="form-select mt-3" name="country">
                                <option value="India">India</option>
                                <option value="USA">USA</option>
                                <option value="UK">UK</option>
                                <option value="Canada">Canada</option>
                            </select>
                            <span id="country-error" class="text-danger"></span>
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
                                    <input type="checkbox" class="form-check-input" name="quali[]" value="4">
                                    <label class="form-check-label" for="check4">PG</label>
                                </div>
                            </div>
                            <span id="quali-error" class="text-danger"></span>
                        </div>
                        <div class="form-group my-4">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <span id="password-error" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Choose Image</label>
                            <input class="form-control" type="file" name="image" />
                            <span id="image-error" class="text-danger"></span>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // var table = '#projects-table';
            var modal = '#add-project-modal';
            var form = '#add-project-form';
            var updateform = '#update-project-form';
            var count = $('#pagenumber').attr("value");
            var gender = [];
            var country = [];
            var quali = "";
            var currdata = [];

            // function to insert values in quealification array qualification 
            $(document).on("click", ".Qualicheckbox", function() {
                var element = $(this).val();
                quali.push(element);
                quali.sort();
            });

            // insert a record 
            $(form).on('submit', function(event) {
                event.preventDefault();

                var url = $(this).attr('data-action');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {

                        // err = response.errors;
                        msg = response.msg;
                        data = response.data;
                        $(".msg").append(
                            `<div class="alert alert-success" role="alert">${msg}</div>`);
                        $('tbody').html('');
                        $.each(data, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }
                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                                <tr id="idrow">
                                    <td>${value.id}</td>
                                    <td>${value.title}</td>
                                    <td>${value.description}</td>
                                    <td>${value.email}</td>
                                    <td>${value.country}</td>
                                    <td>${qualii}</td>
                                    <td>${gen}</td>
                                    <td><img src="${path}" height="70px" width="70px"></td>
                                    <td><button class="deleteRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Delete</button></td>
                                    <td><button class="editRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Edit</button></td>
                                </tr>
                              `)
                        });

                        // $(table).find('tbody').prepend(row);
                        $(form).trigger("reset");
                        setTimeout(function() {
                            $(modal).modal('hide');
                            $(".msg").html('');
                        }, 1000);
                        // $(modal).modal('hide');
                    },
                    error: function(data) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function(index, value) {
                            if (value.title) {
                                $('#title-error').text(value.title);
                            }
                            if (value.description) {
                                $('#desc-error').text(value.description);
                            }
                            if (value.email) {
                                $('#email-error').text(value.email);
                            }
                            if (value.gender) {
                                $('#gender-error').text(value.gender);
                            }
                            if (value.quali) {
                                $('#quali-error').text(value.quali);
                            }
                            if (value.password) {
                                $('#password-error').text(value.password);
                            }
                            if (value.image) {
                                $('#image-error').text(value.image);
                            }
                            setTimeout(function() {
                                $("#title-error").html('');
                                $("#desc-error").html('');
                                $('#email-error').html('');
                                $("#gender-error").html('');
                                $("#quali-error").html('');
                                $('#password-error').html('');
                                $('#image-error').html('');
                            }, 5000);
                        });

                    }
                });
            });

            // delete a record 
            $(document).on("click", ".deleteRecord", function() {
                var id = $(this).data("id");
                var element = $(this);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: '/projects/' + id,
                    type: 'GET',
                    method: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function(response) {
                        $(".delmsg").append(
                            `<div class="alert alert-success" role="alert">${response}</div>`
                        );
                        $(element).closest("tr").hide();
                        setTimeout(function() {
                            $(".delmsg").html('');
                        }, 2000);
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });
            });

            // search filter 
            $(document).on("keyup", "#myInput", function() {
                var value = $(this).val().toLowerCase();
                $.ajax({
                    // url: '/searchs?search=' + value,
                    url: '/search',
                    method: 'GET',
                    data: {
                        "value": value,
                        "page": count,
                    },
                    success: function(response) {
                        $('tbody').html('');
                        count = response.count;
                        $.each(response, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }

                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                                <tr id="idrow">
                                    <td>${value.id}</td>
                                    <td>${value.title}</td>
                                    <td>${value.description}</td>
                                    <td>${value.email}</td>
                                    <td>${value.country}</td>
                                    <td>${qualii}</td>
                                    <td>${gen}</td>
                                    <td><img src="${path}" height="70px" width="70px"></td>
                                    <td><button class="deleteRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Delete</button></td>
                                    <td><button class="editRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Edit</button></td>
                                </tr>
                              `)
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });
            });

            // sort record by accending or decending 
            $('#sort').change(function() {
                var selectedValue = parseInt(jQuery(this).val());
                var sort = "";
                var count = $('#pagenumber').attr("value");
                switch (selectedValue) {
                    // Aecending operations 
                    case 0:
                        sort = "asc";
                        break;
                        // decending operations
                    case 1:
                        sort = "desc";
                        break;
                        // nothing by default value
                    default:
                        console.log("Nothing!");
                        break;
                }
                $.ajax({
                    // url: '/searchs?search=' + value,
                    url: '/sort/' + count,
                    method: 'GET',
                    data: {
                        "sort": sort,
                    },
                    success: function(response) {
                        $('tbody').html('');
                        $.each(response, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }

                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                                <tr id="idrow">
                                    <td>${value.id}</td>
                                    <td>${value.title}</td>
                                    <td>${value.description}</td>
                                    <td>${value.email}</td>
                                    <td>${value.country}</td>
                                    <td>${qualii}</td>
                                    <td>${gen}</td>
                                    <td><img src="${path}" height="70px" width="70px"></td>
                                    <td><button class="deleteRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Delete</button></td>
                                    <td><button class="editRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Edit</button></td>
                                </tr>
                              `)
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });

            });

            // pagination in laravel 
            $(document).on("click", "#pagenumber", function() {
                var count = $(this).attr("value");
                $.ajax({
                    url: '/ajaxindex/' + count,
                    method: 'GET',
                    success: function(response) {
                        data = response.data;
                        $('tbody').html('');
                        $.each(data, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }

                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                                <tr id="idrow">
                                    <td>${value.id}</td>
                                    <td>${value.title}</td>
                                    <td>${value.description}</td>
                                    <td>${value.email}</td>
                                    <td>${value.country}</td>
                                    <td>${qualii}</td>
                                    <td>${gen}</td>
                                    <td><img src="${path}" height="70px" width="70px"></td>
                                    <td><button class="deleteRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Delete</button></td>
                                    <td><button class="editRecord btn  btn-sm btn-danger"
                                            data-id=${value.id}>Edit</button></td>
                                </tr>
                            `)
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });

            });

            // Edit a record 
            $(document).on("click", ".editRecord", function() {
                var var_id = $(this).data("id");
                var element = $(this);
                var token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: '/edit',
                    type: 'GET',
                    data: {
                        "id": var_id,
                        "count": count,
                        "_token": token,
                    },
                    success: function(response) {
                        var_id = response.id;
                        data = response.data;
                        $('tbody').html('');
                        $.each(data, function(key, value) {
                            if (value.id != var_id) {
                                var gen = value.gender;
                                var qualii = "";
                                var path = "images/" + value.image;

                                if (value.gender == "M") {
                                    gen = "Male"
                                } else if (value.gender == "F") {
                                    gen = "Female"
                                } else {
                                    gen = "Others"
                                }

                                for (let i = 0; i < value.quali.length - 1; i++) {
                                    var item = value.quali[i];
                                    if (item == "1") {
                                        qualii = qualii + " 10th"
                                    } else if (item == "2") {
                                        qualii = qualii + " 12th"
                                    } else if (item == "3") {
                                        qualii = qualii + " UG"
                                    } else if (item == "4") {
                                        qualii = qualii + " PG"
                                    }

                                }

                                $("tbody").append(`
                                    <tr id="idrow">
                                        <td>${value.id}</td>
                                        <td>${value.title}</td>
                                        <td>${value.description}</td>
                                        <td>${value.email}</td>
                                        <td>${value.country}</td>
                                        <td>${qualii}</td>
                                        <td>${gen}</td>
                                        <td><img src="${path}" height="70px" width="70px"></td>
                                        <td><button class="deleteRecord btn  btn-sm btn-danger"
                                                data-id=${value.id}>Delete</button></td>
                                        <td><button class="editRecord btn  btn-sm btn-danger"
                                                data-id=${value.id}>Edit</button></td>
                                    </tr>
                                `)
                            } else {
                                var gen = value.gender;
                                var qualii = "";
                                var path = "images/" + value.image;

                                if (value.gender == "M") {
                                    gen = "Male"
                                } else if (value.gender == "F") {
                                    gen = "Female"
                                } else {
                                    gen = "Others"
                                }

                                for (let i = 0; i < value.quali.length - 1; i++) {
                                    var item = value.quali[i];
                                    if (item == "1") {
                                        qualii = qualii + " 10th"
                                    } else if (item == "2") {
                                        qualii = qualii + " 12th"
                                    } else if (item == "3") {
                                        qualii = qualii + " UG"
                                    } else if (item == "4") {
                                        qualii = qualii + " PG"
                                    }

                                }
                                $("tbody").append(`
                                    <tr id="idrow">
                                            <td> ${value.id}</td>
                                            <td><input type="text" class="form-control" id="title" placeholder="Title" value="${value.title}" name="title"></td>
                                            <td><input type="text" class="form-control" id="description"  placeholder="Description" value="${value.description}" name="description"></td>
                                            <td><input type="email" class="form-control" id="email" placeholder="Email" value="${value.email}" name="email"></td>
                                            <td>
                                            <div class="form-group">
                                                <select class="form-select mt-3" name="country">
                                                    <option value="India">India</option>
                                                    <option value="USA">USA</option>
                                                    <option value="UK">UK</option>
                                                    <option value="Canada">Canada</option>
                                                </select>
                                            </div></td>
                                            <td>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="Qualicheckbox form-check-input" name="quali[]" value="1">
                                                    <label class="form-check-label" for="check1">10th</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="Qualicheckbox form-check-input" name="quali[]" value="2">
                                                    <label class="form-check-label" for="check2">12th</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="Qualicheckbox form-check-input" name="quali[]" value="3">
                                                    <label class="form-check-label" for="check3">UG</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="Qualicheckbox form-check-input" name="quali[]" value="4">
                                                    <label class="form-check-label" for="check4">PG</label>
                                                </div>
                                            </div></td>
                                            <td style="white-space: nowrap;">
                                                <input type="radio" class="form-check-input" name="gender" value="M">MALE <br/>
                                                <input type="radio" class="form-check-input" name="gender" value="F">FEMALE <br/>
                                                <input type="radio" class="form-check-input" name="gender" value="O">OTHERS <br/>
                                            </td>
                                            <td><img src="${path}" height="70px" width="70px"></td>
                                            <td><button class="deleteRecord btn  btn-sm btn-danger"
                                                    data-id=${value.id}>Delete</button></td>
                                            <td><button type="submit" class="updateRecord btn  btn-sm btn-info"
                                                    data-id=${value.id}>Update</button></td>
                                        
                                    </tr>                                    
                                `)
                            }
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });
            });

            // Update a record 
            $(document).on("click", ".updateRecord", function() {
                var var_id = $(this).data("id");
                var element = $(this);
                var token = $("meta[name='csrf-token']").attr("content");
                var title = $('#title').val();
                var description = $('#description').val();
                var country = $('select[name=country] option:selected').val();
                var email = $('#email').val();
                var gender = $('input[name="gender"]:checked').val();
                var qualification = quali;
                quali = [];
                var qualiString = "";
                qualification.forEach(element => {
                    qualiString += element + ',';
                });
                $.ajax({
                    url: '/update',
                    type: 'POST',
                    data: {
                        "id": var_id,
                        "count": count,
                        "title": title,
                        "description": description,
                        "email": email,
                        "country": country,
                        "gender": gender,
                        "qualification": qualiString,
                        "_token": token,
                    },
                    success: function(response) {
                        var_id = response.id;
                        data = response.data;
                        $('tbody').html('');
                        $.each(data, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }

                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                            <tr id="idrow">
                                <td>${value.id}</td>
                                <td>${value.title}</td>
                                <td>${value.description}</td>
                                <td>${value.email}</td>
                                <td>${value.country}</td>
                                <td>${qualii}</td>
                                <td>${gen}</td>
                                <td><img src="${path}" height="70px" width="70px"></td>
                                <td><button class="deleteRecord btn  btn-sm btn-danger"
                                        data-id=${value.id}>Delete</button></td>
                                <td><button class="editRecord btn  btn-sm btn-danger"
                                        data-id=${value.id}>Edit</button></td>
                            </tr>
                        `)
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });
            });

            // filter data according to gender,quali,country
            $(document).on("click", "#filterbtn", function() {
                gender = [];
                country = [];
                quali = "";
                $("input:checkbox[name=gender]:checked").each(function(){
                    gender.push($(this).val());
                });
                $("input:checkbox[name=country]:checked").each(function(){
                    country.push($(this).val());
                });
                $("input:checkbox[name=quali]:checked").each(function(){
                    quali = quali+($(this).val())+",";
                    // quali.sort();
                });
                console.log(gender);
                console.log(country);
                console.log(quali);

                $.ajax({
                    url: '/filters',
                    type: 'GET',
                    data: {
                        "gender": gender,
                        "country" : country,
                        "quali" : quali,
                    },
                    success: function(response) {
                        $('tbody').html('');
                        $.each(response, function(key, value) {
                            var gen = value.gender;
                            var qualii = "";
                            var path = "images/" + value.image;

                            if (value.gender == "M") {
                                gen = "Male"
                            } else if (value.gender == "F") {
                                gen = "Female"
                            } else {
                                gen = "Others"
                            }

                            for (let i = 0; i < value.quali.length - 1; i++) {
                                var item = value.quali[i];
                                if (item == "1") {
                                    qualii = qualii + " 10th"
                                } else if (item == "2") {
                                    qualii = qualii + " 12th"
                                } else if (item == "3") {
                                    qualii = qualii + " UG"
                                } else if (item == "4") {
                                    qualii = qualii + " PG"
                                }

                            }
                            $("tbody").append(`
                            <tr id="idrow">
                                <td>${value.id}</td>
                                <td>${value.title}</td>
                                <td>${value.description}</td>
                                <td>${value.email}</td>
                                <td>${value.country}</td>
                                <td>${qualii}</td>
                                <td>${gen}</td>
                                <td><img src="${path}" height="70px" width="70px"></td>
                                <td><button class="deleteRecord btn  btn-sm btn-danger"
                                        data-id=${value.id}>Delete</button></td>
                                <td><button class="editRecord btn  btn-sm btn-danger"
                                        data-id=${value.id}>Edit</button></td>
                            </tr>
                        `)
                        });
                    },
                    error: function(response) {
                        // console.log(response.error);
                    }
                });
                
            });

        });
    </script>

</body>

</html>
