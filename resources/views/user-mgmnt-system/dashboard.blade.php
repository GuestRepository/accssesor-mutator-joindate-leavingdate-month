<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user managment system</title>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<style>
    input.largerCheckbox {
        width: 25px;
        height: 40px;
    }

    .error {
        color: red;
    }

</style>

<body>
    <div class="container">
        <div class="row mt-5">



            <h2>User Records</h2>

            <button class="btn btn-primary offset-md-8" data-bs-toggle="modal" data-bs-target="#userManagment"> Add new
            </button>


            <div class="card-body" id="show_all_users">
                <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>



        </div>
    </div>


    <!-- The Modal -->
    <div class="modal" id="userManagment">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-header">
                    <h4 class="modal-title w-100 text-center">Add new record</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>



                </div>

                <!-- Modal body -->
                <form action="#" method="POST" id="add_user_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- form body open -->
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" id="staticEmail" value="">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="text" class="col-sm-4 col-form-label">Full Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="fullName">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="text" class="col-sm-4 col-form-label">Date Of Joining</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_of_joining" id="dateOfJoin">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="text" class="col-sm-4 col-form-label">Date Of leaving</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date_of_leaving" id="dateOfLeaving">
                            </div>

                            <div class="col-sm-1" id="isStillWorkingSelected">
                                <input type="checkbox" class="form-control largerCheckbox" name="still_working_status"
                                    id="isWorkingSelected" value="NULL">

                            </div>
                            <label for="text" id="isStillWorkingLabel" class="col-sm-3 col-form-label">Still
                                working</label>

                        </div>
                        <div class="mb-3 row">
                            <label for="text" class="col-sm-4 col-form-label">Upload image</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="avatar" id="avatarPic">
                            </div>
                        </div>
                        <!-- form body close -->
                        <button type="submit" class="btn btn-success float-right mb-1"
                            id="add_user_mgmt_btn">Save</button>
                    </div>



                </form>

            </div>
        </div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</body>

</html>


<script>
    $(document).ready(function () {
        $("#isWorkingSelected").on('change', function () {
            if ($(this).is(':checked')) {
                $(this).attr('value', 'true');
                $("#dateOfLeaving").attr('disabled', 'disabled');
            } else {
                $(this).attr('value', 'false');
                $('#still_working_status').val('false');
                $("#dateOfLeaving").removeAttr('disabled');
            }
        });

        // form validation open
        $('#add_user_form').validate({
            rules: {
                name: "required",
                email: "required",
                date_of_joining: "required",
                avatar: "required"
            },
            messages: {
                name: "please enter your name",
                email: "please enter valid email address",
                date_of_joining: "please fill the date",
                avatar: "please select the file"
            }
        });
        // form validation close
        
        $("#add_user_form").submit(function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            // $("#add_user_mgmt_btn").text('saving...');
            $.ajax({
                url: '{{ route('store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                
                success: function (response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Added!',
                            'user Added Successfully!',
                            'success'
                        )
                        fetchAllUserManagementSystem();
                    }
                  
                    $("#add_employee_btn").text('Add Employee');
                    $("#add_user_form")[0].reset();
                    // $("#add_user_mgmt_btn")[0].reset();
                    // $('#add_user_form').ajax.reload();
                    $("#dateOfLeaving").removeAttr('disabled');
                    $("#userManagment").modal('hide');
                }

                

            });
        });

        // delete employee ajax request
        $(document).on('click', '.deleteIcon', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function (response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'user record has been deleted.',
                                'success'
                            )
                            fetchAllUserManagementSystem();
                        }
                    });
                }
            })
        });

        // fetch all fetchAllUserManagementSystem ajax request
        fetchAllUserManagementSystem();

        function fetchAllUserManagementSystem() {
            $.ajax({
                url: '{{ route('fetchAll') }}',
                method: 'get',
                success: function (response) {
                    $("#show_all_users").html(response);
                    $("#dataTable").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

          

        $('#userManagment').click(function () {
            $('#add_user_mgmt_btn').html('save');
            $("#dateOfLeaving").removeAttr('disabled');
        });

    });

</script>
