@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Blog</h4>
                        <a href="{{ url('blogs') }}" class="btn btn-default btnwhite">Back To Blogs</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editcommunityForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="blogId" value="{{ $blog->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" class="form-control" type="text" value="{{ $blog->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appt">Description</label>
                                              <textarea type="text" class="form-control"  name="description" >{{ $blog->description }}</textarea>
                                           <!--  <input type="text" value="{{ $blog->description }}" class="form-control"  name="description" > -->
                                        </div>
                                    </div>
                                      <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Image</label>
                                        <input class="form-control" onchange="readURL(this)" type="file" id="user-img" name="image" >
                                </div>
                                </div>
                                @if(!empty($blog->image))
                                   <div class="user-image ">
                                     <img class="img-thumbnail" src="{{ url('/public/assets/image/blog')}}/{{ $blog->image  == '' ? 'default-profile-img.png' : $blog->image}}" id="profile_img_id">
                                                  
                                  </div>
                                  @endif
                                </div>

                                <div class="mt-2">
                                    <button class="btn btn-success" type="submit" id="sbtButton">Save Changes</button>
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
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
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
    
    $("#editcommunityForm").validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            title: "Please enter title",
            description: "Please enter description."
        },
        submitHandler: function(form) {
           var form2 = $('#editcommunityForm')[0];
            var serializedData = new FormData(form2);
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('update-blog') }}",
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
                         window.location.href = _baseURL+'/blogs';
                    } else {
                        let errMsgs = '';
                        for (const x of data.message) {
                            errMsgs += x +'';
                        }
                        var form = document.createElement("div");
                        form.innerHTML = errMsgs;
                        
                        swal({
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
    $(function () {
        $('#pickup_time').datetimepicker({
            format: 'LT'
        });
    });
</script>
@endsection