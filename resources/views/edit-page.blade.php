@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Page</h4>
                        <a href="{{ url('/pages') }}" class="btn btn-default btnwhite">Back To Pages</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('update-page') }}" id="editPageForm">
                                        @csrf
                                        <input type="hidden" name="pageId" value="{{ $page->id }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input class="form-control" name="title" type="text" value="{{ $page->title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="content" id="content" class="form-control h-auto" rows="7">{{ $page->content }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button class="btn btn-primary" id="sbtButton" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    $("#editPageForm").validate({
        rules: {
            title: {
                required: true,
                minlength: 2
            },
            content: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            title: "Please enter title.",
            content: "Please enter page content."
        },
        submitHandler: function(form) {
            var serializedData = $(form).serialize();
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $('#sbtButton').prop('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('update-page') }}",
                data: serializedData,
                dataType: 'json',
                success: function(data) {
                    $('#sbtButton').prop('disabled', false);
                    $('#sbtButton').html('Save Changes');
                    if (data.erro == '101') {
                        swal("", data.message, "success", {
                            button: "close",
                        });
                    } else {
                        let errMsgs = '';
                        for (const x of data.message) {
                            errMsgs += x + '';
                        }
                        swal("", errMsgs, "error", {
                            button: "close",
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    $('#sbtButton').prop('disabled', false);
                    $('#sbtButton').html('Save Changes');
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }

                    swal("", msg, "error", {
                        button: "close",
                    });
                },
            });
            return false;
        }
    });
</script>
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
       var editor1 =  CKEDITOR.replace('content', {});
        editor1.on('change', function() { 
             editor1.updateElement();
        });
    });
</script>
@endsection