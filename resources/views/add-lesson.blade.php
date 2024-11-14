@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Lesson</h4>
                        <a href="{{ url('lessons') }}" class="btn btn-default btnwhite">Back To Lesson</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <form method="POST"action="" id="addUserForm">
                                        @csrf
                              
                                <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" type="text" value=""></textarea>
                                        </div>
                                    </div>
                                                    <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="Country">Select Module</label>
                                        <select class="form-control" name="module" data-toggle="select2">
                                        <option value="">Select Module</option>
                                               @foreach($module as $authh)
                                              
                                              <option value="{{$authh->id}}">{{$authh->name}}</option>
                                             
                                              @endforeach
                                    </select>
                                </div>
                                </div>
                                           <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="Country">Select Course</label>
                                        <select class="form-control" name="course" data-toggle="select2">
                                        <option value="">Select Course</option>
                                               @foreach($course as $con)
                                              
                                              <option value="{{$con->id}}">{{$con->title}}</option>
                                             
                                              @endforeach
                                    </select>
                                </div>
                                </div>
                                
                                     <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Video</label>
                                      <input name="videofile" class="form-control" type="file" value="">
                                </div>
                                </div>
                                        </div>

                                    <div class="mt-2">
                                        <button class="btn btn-success" type="submit" id="sbtButton">Submit</button>
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
<script>

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
        //  $('#profile_img_id').attr('src', file.name);
        //     $('#p_image').attr('src', file.name);
        console.log(file);

        // var formdata = new FormData();
        // formdata.append("file1", file);
        // var ajax = new XMLHttpRequest();
        // ajax.upload.addEventListener("progress", progressHandler, false);
        // ajax.addEventListener("load", completeHandler, false);
        // ajax.addEventListener("error", errorHandler, false);
        // ajax.addEventListener("abort", abortHandler, false);
        // ajax.open("POST", "{{ url('update_profile_pic') }}");
        // ajax.setRequestHeader('X-CSRF-Token', $('input[name="_token"]').val());
        // ajax.responseType = 'json';

        // ajax.send(formdata);
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
    
    $(document).ready(function(){
        $('.not-to-show').hide();
        $('.not-to-show-to-user').hide();
            $("#addUserForm").validate({
            rules: {
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                module: {
                    required: true,
                },
                course: {
                    required: true,
                }
    
            },
            messages: {
                title: "Please enter title",
             
                description: "Please enter description",
             
                module: {
                    required: "Please select module",
                },
                course: {
                    required: "Please select course",
                }
            },
            submitHandler: function(form) {
                 var form = $('#addUserForm')[0];
                var serializedData = new FormData(form);
                $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    type: 'post',
                    url: "{{ url('insertlession') }}",
                    data: serializedData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    dataType: 'json',
                    success: function(data) {
                        $('#sbtButton').html('Submit');
    
                        if (data.code == 200) {
                            swal("", data.message, "success", {
                                button: "close",
                            });
    
                            // $("#addUserForm").trigger('reset');
                            // window.location.href = _baseURL+'/lessons';
                        } else {
                            
                            var errMsgs = '';
                            for (var i = 0; i < data.message.length; i++) {
                                var obj = data.message[i];
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
    
                           /* swal('', errMsgs, "error", {
                                button: "close",
                            });*/
                        }
    
    
                    }
                });
                return false;
            }
        });
    });
    
    
    
    
    $.validator.addMethod("strong_password", function (value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(.{6,12}$)/.test(password))) {
            return false;
        }
        return true;
    }, function (value, element) {
        let password = $(element).val();
        if(!(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,12}$/.test(password))){
            return 'Password must be between 6 and 12 characters with at least one capital letter, one small letter, and one digit.';
        }
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

    $('#role').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if (valueSelected == 'user') {
            $('.not-to-show').show();
        } else {
            $('.not-to-show').hide();
        }
        
        if (valueSelected == 'pickupPerson' || valueSelected == 'propertyManager') {
            $('.not-to-show-to-user').show();
        } else {
            $('.not-to-show-to-user').hide();
        }
        
        
        
    });
</script>
@endsection