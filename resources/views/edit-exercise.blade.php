@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Exercise</h4>
                        <a href="{{ url('exercises') }}" class="btn btn-default btnwhite">Back To Exercises</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editUserForm" enctype="multipart/form-data"> 
                                @csrf
                                <div class="row">
                                <input type="hidden" name="ExerciseId" value="{{ $exercise->id }}">
                                 <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" class="form-control" type="text" value="{{ $exercise->excercise_name }}">
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tilte</label>
                                            <input name="title" class="form-control" type="text" value="{{ $exercise->excercise_title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" type="text" value="">{{ $exercise->excercise_description }}</textarea>
                                        </div>
                                    </div>
                                                  <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="Country">Select Module</label>
                                        <select class="form-control" name="module" data-toggle="select2">
                                        <option value="">Select Module</option>
                                               @foreach($module as $authh)
                                              
                                              <option {{$authh->id == $exercise->module_id ? 'selected' : ''}} value="{{$authh->id}}">{{$authh->name}}</option>
                                             
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
                                              
                                              <option {{$con->id == $exercise->course_id ? 'selected' : ''}} value="{{$con->id}}">{{$con->title}}</option>
                                             
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
                                              
                                              <option {{$less->id == $exercise->lesson_id ? 'selected' : ''}} value="{{$less->id}}">{{$less->title}}</option>
                                             
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
                                              
                                              <option {{$ass->form == $exercise->exercise_form ? 'selected' : ''}} value="{{$ass->id}}">{{$ass->title}}</option>
                                             
                                              @endforeach
                                    </select>
                                </div>
                                </div>
                                  
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
    $("#editUserForm").validate({
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
                 name: {
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
                title: "Please enter title",
             
                description: "Please enter description",
              name: "Please enter name",
                lesson: {
                    required: "Please select lesson",
                }, 
                assignment: {
                    required: "Please select assignment",
                },
                module: {
                    required: "Please select module",
                },
                course: {
                    required: "Please select course",
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
                url: "{{ url('update-exercise') }}",
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
                         window.location.href = _baseURL+'/exercises';
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