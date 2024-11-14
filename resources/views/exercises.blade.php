@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Exercises</h4>
                        <a href="{{ url('add-exercise') }}" class="btn btn-default btnwhite">Add Exercise</a>
                    </div>
                    <div class="card-body">
                     
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($exercises) > 0)
                                    @foreach($exercises as $lsn)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        
                                        <td>{{ $lsn->excercise_name == '' ? '-NA-' :  $lsn->excercise_name }}</td>
                                        <td>{{ $lsn->excercise_title == '' ? '-NA-' :  $lsn->excercise_title }}</td>
                                        <td>{{ Str::limit($lsn->excercise_description, 20, ' ...') }}</td>
                                        <td>
                                            <!--<a href="{{ url('view-user') }}/{{ $lsn->id }}" class="btn btn-sm bg-info-light">-->
                                            <!--    <i class="far fa-eye mr-1"></i>-->
                                            <!--</a>-->
                                            <a href="{{ url('edit-exercise') }}/{{ $lsn->id }}" class="btn btn-sm bg-success-light">
                                                <i class="far fa-edit mr-1"></i>
                                            </a>
                                            <a href="javascript: void(0)" onclick="checkId('{{ $lsn->id }}')" data-toggle="modal" data-target="#deletemodaluser" class="btn btn-sm bg-danger-light delete_review_comment">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No Exercise Found.</td>
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
                <p>Are you sure you want to delete this exercise? This process cannot be undone</p>
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
            url: "{{ url('delete-exercise') }}",
            data: {
                id: deletedId
            },
            dataType: 'json',
            success: function(data) {
                if (data.code == 200) {
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