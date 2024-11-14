@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Exercise</h4>
                        <a href="{{ url('exercises') }}" class="btn btn-default btnwhite">Back To Exercises</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <form method="POST"action="" id="addUserForm">
                                        @csrf
                              
                                <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" class="form-control" type="text" value="">
                                        </div>
                                    </div>
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
                                      <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="Country">Select Lesson</label>
                                        <select class="form-control" name="lesson" data-toggle="select2">
                                        <option value="">Select Lesson</option>
                                               @foreach($lesson as $less)
                                              
                                              <option value="{{$less->id}}">{{$less->title}}</option>
                                             
                                              @endforeach
                                    </select>
                                </div>
                                </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="Country">Select Assignment</label>
                                        <select class="form-control" name="assignment" data-toggle="select2">
                                        <option value="">Select Assignment</option>
                                               @foreach($assignment as $ass)
                                              
                                              <option value="{{$ass->id}}">{{$ass->title}}</option>
                                              
                                              @endforeach 
                                    </select>
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

    
    $(document).ready(function(){
        $('.not-to-show').hide();
        $('.not-to-show-to-user').hide();
            $("#addUserForm").validate({
            rules: {
                name: {
                    required: true,
                },
                 title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                module: {
                    required: true,
                },
                 lesson: {
                    required: true,
                },
                 assignment: {
                    required: true,
                },
                course: {
                    required: true,
                }
    
            },
            messages: {
                name: "Please enter name",
                title: "Please enter title",
             
                description: "Please enter description",
             
                module: {
                    required: "Please select module",
                },
                 lesson: {
                    required: "Please select lesson",
                }, 
                assignment: {
                    required: "Please select assignment",
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
                    url: "{{ url('insertexercise') }}",
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
    
                            $("#addUserForm").trigger('reset');
                            window.location.href = _baseURL+'/exercises';
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