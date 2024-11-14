@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Motivation</h4>
                        <a href="{{ url('motivations') }}" class="btn btn-default btnwhite">Back To Motivations</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <form method="POST" action="" id="addCommunityForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label>Quote</label>
                                           <textarea class="form-control"  name="quote" rows="6" placeholder="Write Text...">
                            </textarea>
                                        </div>
                                    </div>
                                       <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Image</label>
                                        <input class="form-control" type="file" id="user-img" name="image" value="" >
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

$(document).ready(function() {
  
        CKEDITOR.replace( 'quote' );
            
         });
   
    $("#addCommunityForm").validate({
        rules: {
            // quote: {
            //     required: true
            // },
            image: {
                required: true
            },
                videofile: {
                    required: true,
                }
        },
        messages: {
            // quote: "Please enter title",
            image: "Please upload image",
            videofile: "Please upload video"
        },
        submitHandler: function(form) {
              for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
            var form2 = $('#addCommunityForm')[0];
            var serializedData = new FormData(form2);
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('insertmotivation') }}",
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

                        $("#addCommunityForm").trigger('reset');
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
                        
                        
                        /*swal("", errMsgs, "error", {
                            button: "close",
                        });*/
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