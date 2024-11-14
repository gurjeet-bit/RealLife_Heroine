@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Blog</h4>
                        <a href="{{ url('blogs') }}" class="btn btn-default btnwhite">Back To Blogs</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <form method="POST" action="" id="addCommunityForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label>Title</label>
                                            <input name="title" class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pickup_time">Description</label>
                                            <textarea type="text" class="form-control"  name="description" ></textarea>
                                        </div>
                                    </div>
                                       <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="Country">Upload Image</label>
                                        <input class="form-control" type="file" id="user-img" name="image" value="" >
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
<script>
   
    $("#addCommunityForm").validate({
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
            var form2 = $('#addCommunityForm')[0];
            var serializedData = new FormData(form2);
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('insertblog') }}",
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