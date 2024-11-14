@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Podcast</h4>
                        <a href="{{ url('podcasts') }}" class="btn btn-default btnwhite">Back To Podcasts</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editcommunityForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="podcastId" value="{{ $podcast->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Artist Name</label>
                                            <input name="artist" class="form-control" type="text" value="{{ $podcast->artist }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appt">Album Name</label>
                                            <input type="text" value="{{ $podcast->album }}" class="form-control"  name="album" >
                                        </div>
                                    </div>
                                      <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Cover Photo</label>
                                        <input class="form-control" type="file" id="user-img" name="image" onchange="readURL(this)">
                                </div>
                                </div>
                                @if(!empty($podcast->cover_photo))
                                   <div class="user-image ">
                                     <img class="img-thumbnail" style="height:200px !important;" src="{{ url('/public/assets/image/cover')}}/{{ $podcast->cover_photo  == '' ? 'default-profile-img.png' : $podcast->cover_photo}}" id="profile_img_id">
                                                  
                                  </div><br>
                                  @endif
                                  
                                        <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Audio</label>
                                        <input class="form-control" type="file" id="user-img1" name="audio" onchange="readURL1(this)">
                                </div>
                                </div>
                                @if(!empty($podcast->song))
                                   <div class="user-image ">
                                   <audio controls="" style="vertical-align: middle" src="{{ url('/public/assets/audio')}}/{{ $podcast->song  == '' ? 'default-profile-img.png' : $podcast->song}}" type="audio/mp3" controlslist="nodownload" id="audiosong">
                                      </audio>
                                                  
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
    
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#audiosong').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            
        }
    }
    
    $("#editcommunityForm").validate({
        rules: {
              artist: {
                required: true
            },
            album: {
                required: true
            }
        },
        messages: {
             artist: "Please enter artist",
            album: "Please enter album"
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
                url: "{{ url('update-podcast') }}",
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
                         window.location.href = _baseURL+'/podcasts';
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