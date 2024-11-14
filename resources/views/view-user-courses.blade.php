@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Python <span class="badge badge-pill badge-danger pendingHeading">Completed</span></h4>
                        <a href="{{ url('users') }}" class="btn btn-default btnwhite">Back To Courses</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox accord_new">
                            <div class="accordion" id="accordionExample">
                              <div class="card">
                                <div class="card-header" id="headingOne">
                                  <h2 class="mb-0 d-flex align-items-center justify-content-between">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      Module 1
                                    </button>

                                    <span class="badge badge-pill badge-danger compleHeading">Pending</span> 
                                  </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                  <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Name</th>
                                                    <th>Progress</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr> 
                                                    <td>1</td>
                                                    <td>Lesson 1</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">20%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span> 
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td>2</td>
                                                    <td>Lesson 2</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">40%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-danger">Pending</span> 
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td>3</td>
                                                    <td>Lesson 3</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">60%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card">
                                <div class="card-header" id="headingTwo">
                                  <h2 class="mb-0 d-flex align-items-center justify-content-between">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                      Module 2
                                    </button>

                                     <span class="badge badge-pill badge-success compleHeading">Completed</span> 
                                  </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                  <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Name</th>
                                                    <th>Progress</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr> 
                                                    <td>1</td>
                                                    <td>Lesson 1</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">20%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span> 
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td>2</td>
                                                    <td>Lesson 2</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">40%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-danger">Pending</span> 
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td>3</td>
                                                    <td>Lesson 3</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">60%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Of Users -->
        </div>
    </div>
</div>

@endsection

@section('customScripts')

<script src="{{url('/')}}/public/assets/js/socket.io.js"></script>
<script>

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile_img_id').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            
            var formdata = new FormData();
        formdata.append("file1", input.files[0]);
        formdata.append("id", $('input[name="userId"]').val());
        formdata.append("X-CSRF-Token", $('input[name="_token"]').val());
        var ajax = new XMLHttpRequest();
        // ajax.upload.addEventListener("progress", progressHandler, false);
        // ajax.addEventListener("load", completeHandler, false);
        // ajax.addEventListener("error", errorHandler, false);
        // ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "{{ url('update_userprofile_pic') }}");
        ajax.setRequestHeader('X-CSRF-Token', $('input[name="_token"]').val());
        ajax.responseType = 'json';

        ajax.send(formdata);
        }
    }
    
    var _validFileExtensions = ['.jpg', 'png', 'jpeg', 'gif'];
    var validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];

    function _(el) {
        return document.getElementById(el);
    }

    function uploadFile() {
        var file = _("user-img").files[0];
        $('#erre_mess').html("");
        $('#status').html("");
        $('#loaded_n_total').html("");
        if (!validImageTypes.includes(file.type)) {
            $('#erre_mess').html("Sorry, Uploaded file is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
            return false;
        }

        var formdata = new FormData();
        formdata.append("file1", file);
        formdata.append("id", $('input[name="userId"]').val());
        formdata.append("X-CSRF-Token", $('input[name="_token"]').val());
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "{{ url('update_userprofile_pic') }}");
        ajax.setRequestHeader('X-CSRF-Token', $('input[name="_token"]').val());
        ajax.responseType = 'json';

        ajax.send(formdata);
    }

    function progressHandler(event) {
        $('#progressBar').show();
        _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);

        if (Math.round(percent) == '100' || Math.round(percent) == 100) {
            _("status").innerHTML = "File uploaded. We are generating report now...";
        } else {
            _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

    }

    function completeHandler(event) {
        $('#progressBar').hide();
        $('#loaded_n_total').hide();
        if (event.target.response.img == '') {
            _("status").innerHTML = event.target.response.response;
        } else {
            $('#profile_img_id').attr('src', event.target.response.img);
            $('#p_image').attr('src', event.target.response.img);
            _("status").innerHTML = event.target.response.response;
        }

        setTimeout(function() {
            $('#status').html("");
        }, 5000);

        _("progressBar").value = 0; //wil clear progress bar after successful upload
    }

    function errorHandler(event) {
        _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event) {
        _("status").innerHTML = "Upload Aborted";
    }
</script>

<script>
    $("#editUserForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
             path: {
                    required: true
                },
            password: {
                required: function(element) {
                    return $('#password').val().length > 0;
                },
                strong_password: function(element) {
                   return $('#password').val().length > 0;
                },
            },
            confirmPassword: {
                required: function(element) {
                    return $("#password").val() != "";
                },
                equalTo: "#password"
            },

        },
        messages: {
            name: "Please enter your name",
            email: "Please enter a valid email address",
             path: "Please select path",
            confirmPassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        submitHandler: function(form) {
            
            var form2 = $('#editUserForm')[0];
            var serializedData = new FormData(form2);
        
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('update-user') }}",
                data: serializedData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                dataType: 'json',
                success: function(data) {
                    $('#sbtButton').html('Save Changes');
                    

                    if (data.code == 200) {
                        
                        swal("", data.message, "success", {
                            button: "close",
                        });
                         window.location.href = _baseURL+'/users';
                    } else {
                        var errMsgs = '';
                        for (var i = 0; i < data.errors.length; i++) {
                            var obj = data.errors[i];
                            errMsgs += obj + '</br>';
                        }
                        
                        var form = document.createElement("div");
                        form.innerHTML = errMsgs;
                        
                        swal({
                            icon: 'error',
                            title: '',
                            text: '',
                            content: form,
                            buttons: {
                              cancel: "Cancel"
                            }
                        });
                    }


                }
            });
            return false;
        }
    });
    
    $.validator.addMethod("strong_password", function (value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(.{6,12}$)/.test(password))) {
            return false;
        }
        return true;
    }, function (value, element) {
        let password = $(element).val();
        console.log(password);
        if (!(/^(.{6,12}$)/.test(password))) {
            return 'Password must be between 6 to 12 characters long.';
        }
        else if (!(/^(?=.*[A-Z])/.test(password))) {
            return 'Password must contain at least one uppercase.';
        }
        else if (!(/^(?=.*[a-z])/.test(password))) {
            return 'Password must contain at least one lowercase.';
        }
        else if (!(/^(?=.*[0-9])/.test(password))) {
            return 'Password must contain at least one digit.';
        }
        return false;
    });
</script>
@endsection
