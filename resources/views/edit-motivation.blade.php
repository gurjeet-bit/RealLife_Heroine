@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Motivation</h4>
                        <a href="{{ url('motivations') }}" class="btn btn-default btnwhite">Back To Motivations</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editcommunityForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="motivationId" value="{{ $motivation->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Quote</label>
                                             <textarea class="form-control"  name="quote" rows="6" placeholder="Write Text...">
                                {{!empty($motivation->quote) ? $motivation->quote : ''}}
                            </textarea>
                                        </div>
                                    </div>
                                   
                                      <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Image</label>
                                        <input class="form-control" type="file" id="user-img" name="image" onchange="readURL(this)">
                                </div>
                                </div>
                                @if(!empty($motivation->image))
                                   <div class="user-image ">
                                     <img style="height:200px !important;" class="img-thumbnail" src="{{ url('/public/assets/image/motivation')}}/{{ $motivation->image  == '' ? 'default-profile-img.png' : $motivation->image}}" id="profile_img_id">
                                                  
                                  </div>
                                  @endif

                                  <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Video</label>
                                      <input name="videofile" class="form-control" type="file" value="" onchange="readURL1(this)">
                                </div>
                                </div>
                                 @if(!empty($motivation->video))
                                 <div class="user-image ">

                                <video style="height: 200px !important;" class="img-thumbnail" src="{{ url('/public/assets/image/our_video')}}/{{$motivation->video}}" id="profile_img_id1" controls></video>
                                                  
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
 <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
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

$(document).ready(function() {
  
        CKEDITOR.replace( 'quote' );
            
         });
    $("#editcommunityForm").validate({
        rules: {
            // quote: {
            //     required: true
            // },
            // image: {
            //     required: true
            // }
        },
        messages: {
            // quote: "Please enter quote",
            // image: "Please upload image."
        },
        submitHandler: function(form) {
             for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
           var form2 = $('#editcommunityForm')[0];
            var serializedData = new FormData(form2);
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('update-motivation') }}",
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
                         window.location.href = _baseURL+'/motivations';
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