@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Queries</h4>
                        <!--<a href="{{ url('add-community') }}" class="btn btn-default btnwhite">Add Query</a>-->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Query</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($queries) > 0)
                                    @foreach($queries as $comm)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $comm->query == '' ? '-NA-' :  $comm->query }}</td>
                                         <td>  
                                         <!--<a href="{{ url('edit-community') }}/{{ $comm->id }}" class="btn btn-sm bg-success-light">-->
                                         <!--       <i class="far fa-edit mr-1"></i>-->
                                         <!--   </a>-->
                                             <a href="{{ url('view-query') }}/{{ $comm->id }}" class="btn btn-sm bg-info-light">
                                                <i class="far fa-eye mr-1"></i>
                                            </a>
                                            <a href="javascript: void(0)" onclick="checkId('{{ $comm->id }}')" data-toggle="modal" data-target="#deletemodalcommunity" class="btn btn-sm bg-danger-light delete_review_comment">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
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
<div class="modal fade modalCss" tabindex="-1" id="deletemodalcommunity">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="deleteID" id="deleteID">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <i class="far fa-times-circle"></i>
                <p>Are you sure you want to delete this query? This process cannot be undone</p>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="deleteCommunity();" class="btn btn-danger">Delete</button>
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

    function deleteCommunity() {
        var deletedId = $('#deleteID').val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ url('delete-query') }}",
            data: {
                id: deletedId
            },
            dataType: 'json',
            success: function(data) {
                if (data.code == 200) {
                    $('#deletemodalcommunity').hide();
                    swal({
                        title: "",
                        text: data.message,
                        type: "success"
                    });
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
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