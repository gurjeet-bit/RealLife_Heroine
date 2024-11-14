@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Terms & Conditions</h4>
                        <!--<a href="{{ url('podcasts') }}" class="btn btn-default btnwhite">Back To Podcasts</a>-->
                    </div>
                    <div class="card-body">
                        <div class="padBox">

                            <form method="POST" action="" id="editcommunityForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="termsId" value="{{ $terms->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" class="form-control" type="text" value="{{ $terms->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="appt">Description</label>
                                             <textarea class="form-control"  name="description" rows="6" placeholder="Write Text...">
                                            {{!empty($terms->description) ? $terms->description : ''}}
                                        </textarea>
                                        </div>
                                    </div>
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

$(document).ready(function() {
  
        CKEDITOR.replace( 'description' );

            
         });
         
    $("#editcommunityForm").validate({
        rules: {
            title: {
                required: true
            }
        },
        messages: {
            title: "Please enter title"
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
                url: "{{ url('update-terms') }}",
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
                         window.setTimeout(function() {
                        location.reload();
                    }, 3000);
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