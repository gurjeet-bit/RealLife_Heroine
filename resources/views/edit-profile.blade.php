@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Profile Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class=" profile_user">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="user-image ">

                                                    <img class="rounded-circle img-thumbnail" src="{{ url('/public/assets/image/profile')}}/{{ $profiledata->image  == '' ? 'default-profile-img.png' : $profiledata->image}}" id="profile_img_id">
                                                    <form id="upload_pic_form" enctype="multipart/form-data" method="post">
                                                        {{ csrf_field() }}
                                                        <label for="user-img"><i class="fas fa-edit"></i></label>

                                                        <input type="file" id="user-img" name="profile_image" onchange="readURL(this)" style="visibility:hidden; height:0px; width:0px;">   
                                                        <input type="hidden"  name="_token" value="{{ csrf_token() }}" >

                                                    </form>
                                                </div>
                                                <span id="erre_mess" style="color:red;width: 100%;display: inline-block;font-weight: 700;"></span>
                                                <progress style="display:none;" id="progressBar" value="0" max="100" style="width:300px;"></progress>
                                                <h5 id="status" style="color: #25777c;font-weight: 600;"></h5>
                                                <p id="loaded_n_total"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">

                                    <form method="POST" action="" id="editProfileForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h1>Basic Information</h1>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" name="name" type="text" value="{{ $profiledata->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <input readonly class="form-control" type="email" name="email" value="{{ $profiledata->email}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input required class="form-control" id="phoneNo" name="phone" type="text" value="{{ $profiledata->phone }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input class="form-control" name="address" type="text" value="{{ $profiledata->address }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h1>Change Password</h1>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" name="current_password" class="form-control" id="current_password" aria-describedby="emailHelp" placeholder="Old Password" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Confirm New Password</label>
                                                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-success" id="sbtButton" type="submit">Save Changes</button>
                                        </div>
                                    </form>


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

@section('customModals')

@endsection

@section('customScripts')
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
        formdata.append("X-CSRF-Token", $('input[name="_token"]').val());
        var ajax = new XMLHttpRequest();
        // ajax.upload.addEventListener("progress", progressHandler, false);
        // ajax.addEventListener("load", completeHandler, false);
        // ajax.addEventListener("error", errorHandler, false);
        // ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "{{ url('update_profile_pic') }}");
        ajax.setRequestHeader('X-CSRF-Token', $('input[name="_token"]').val());
        ajax.responseType = 'json';

        ajax.send(formdata); 
         swal("", 'Profile Picture Updated', "success", {
                            button: "close",
                        });
                         window.setTimeout(function() {
                        location.reload();
                    }, 2000);
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
        formdata.append("X-CSRF-Token", $('input[name="_token"]').val());
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "{{ url('update_profile_pic') }}");
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
    $("#editProfileForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            phone: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            confirm_password: {
                required: function(element) {
                    return $("#new_password").val() != "";
                },
                equalTo: "#new_password"
            },
        },
        messages: {
            name: "Please enter your name",
            phoneNo: {
                required: "Please provide your phone number",
                number: "only numeric values are allowed"
            },
            email: "Please enter a valid email address",
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        submitHandler: function(form) {
            var serializedData = $(form).serialize();
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('updateadminprofile') }}",
                data: serializedData,
                dataType: 'json',
                success: function(data) {
                    $('#sbtButton').html('Save Changes');

                    if (data.code == 200) {
                        swal("", data.message, "success", {
                            button: "close",
                        });
                         window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                    }else {    
                        swal("", data.message, "error", {
                            button: "close",
                        });
                    }


                }
            });
            return false;
        }
    });
</script>
@endsection