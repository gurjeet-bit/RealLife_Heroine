@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Videos</h4>
                        <a href="{{ url('add-video') }}" class="btn btn-default btnwhite">Add Video</a>
                    </div>
                    <div class="card-body">
                     
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($videos) > 0)
                                    @foreach($videos as $vde)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                           <td><img style="height: 70px!important;width: 70px!important;object-fit: cover!important;" class="rounded-circle img-thumbnail" src="{{ url('/public/assets/image/our_video')}}/{{ $vde->thumbnail_image  == '' ? 'default-profile-img.png' : $vde->thumbnail_image}}" id="profile_img_id"></td>
                                        <td>{{ $vde->title == '' ? '-NA-' :  $vde->title }}</td>
                                        <td>
                                            <!--<a href="{{ url('view-user') }}/{{ $vde->id }}" class="btn btn-sm bg-info-light">-->
                                            <!--    <i class="far fa-eye mr-1"></i>-->
                                            <!--</a>-->
                                            <a href="{{ url('edit-video') }}/{{ $vde->id }}" class="btn btn-sm bg-success-light">
                                                <i class="far fa-edit mr-1"></i>
                                            </a>
                                            <a href="javascript: void(0)" onclick="checkId('{{ $vde->id }}')" data-toggle="modal" data-target="#deletemodaluser" class="btn btn-sm bg-danger-light delete_review_comment">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No Videos Found.</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Of Users -->
        </div>
    </div>
</div>


@endsection


@section('customModals')
<!-- Delete Modal -->
<div class="modal fade modalCss" tabindex="-1" id="deletemodaluser">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="deleteID" id="deleteID">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <i class="far fa-times-circle"></i>
                <p>Are you sure you want to delete this video? This process cannot be undone</p>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="deleteUser();" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('customScripts')
<script>
    function checkId(deletedId) {
        $('#deleteID').val(deletedId);
    }

    function deleteUser() {
        var deletedId = $('#deleteID').val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ url('delete-video') }}",
            data: {
                id: deletedId
            },
            dataType: 'json',
            success: function(data) {
                if (data.code == 200) {
                    $('#deletemodaluser').hide();
                    swal({
                        title: "",
                        text: data.message,
                        type: "success"
                    });
                    window.setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    swal("", data.message, "error", {
                        button: "close",
                    });
                }
            }
        });
    }
</script>
@endsection