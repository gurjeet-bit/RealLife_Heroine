@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Video</h4>
                        <a href="{{ url('videos') }}" class="btn btn-default btnwhite">Back To Video</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editUserForm" enctype="multipart/form-data"> 
                                @csrf
                                <div class="row">
                                <input type="hidden" name="videoId" value="{{ $video->id }}">
                                 <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tilte</label>
                                            <input name="title" class="form-control" type="text" value="{{ $video->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" type="text" value="">{{ $video->description }}</textarea>
                                        </div>
                                    </div>
                                                  
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Video</label>
                                      <input name="videofile" class="form-control" type="file" value="" onchange="readURL(this)">
                                </div>
                                </div>
                                 @if(!empty($video->video))
                                 <div class="user-image ">

                                <video style="height: 200px !important;" class="img-thumbnail" src="{{ url('/public/assets/image/our_video')}}/{{$video->video}}" id="profile_img_id" controls></video>
                                                  
                                 </div>
                                    @endif
                                    
                                         <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Thumbnail Image</label>
                                        <input class="form-control" onchange="readURL1(this)" type="file" id="user-img" name="image" >
                                </div>
                                </div>
                                @if(!empty($video->thumbnail_image))
                                   <div class="user-image ">
                                     <img class="img-thumbnail" src="{{ url('/public/assets/image/our_video')}}/{{ $video->thumbnail_image  == '' ? 'default-profile-img.png' : $video->thumbnail_image}}" id="profile_img_id1">
                                                  
                                  </div>
                                  @endif
                                </div>

                                <div class="mt-2">
                                    <button class="btn btn-success" type="submit" id="sbtButton">Save Changes</button>
                                </div>
                                </div>
                                </div>
                            </form>
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
            
        }
    }
    
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile_img_id1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            
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
                title: {
                    required: true,
                },
                description: {
                    required: true,
                }
    
            },
            messages: {
                title: "Please enter title",
             
                description: "Please enter description"
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
                url: "{{ url('update-video') }}",
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
                         window.location.href = _baseURL+'/videos';
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