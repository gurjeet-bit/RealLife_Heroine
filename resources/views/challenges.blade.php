@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Challenges</h4>
                        <a href="javascript: void(0);" class="btn btn-default btnwhite" data-toggle="modal" data-target="#addModal">Add Challenge</a>
                    </div>

                    <div class="card-body">
                            
                      
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($challenges) > 0)
                                    @foreach($challenges as $challeng)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $challeng->name }}</td>
                                        <td>
                                            <!--<a href="{{ url('/view-complaint') }}/{{ $challeng->id }}" class="btn btn-sm bg-info-light">-->
                                            <!--    <i class="far fa-eye mr-1"></i>-->
                                            <!--</a>-->
                                            <a href="javascript: void(0);" data-id="{{$challeng->id}}" data-name="{{$challeng->name}}" class="btn btn-sm bg-success-light editchallg" data-toggle="modal" data-target="#editModal">
                                                <i class="far fa-edit mr-1"></i>
                                            </a>
                                            <a href="javscript:void(0);" onclick="checkId('{{ $challeng->id }}')" data-toggle="modal" data-target="#deletemodalcomplaints" class="btn btn-sm bg-danger-light delete_review_comment">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No Challenges Found.</td>
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
<div class="modal fade modalCss" tabindex="-1" id="deletemodalcomplaints">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="deleteID" id="deleteID">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <i class="far fa-times-circle"></i>
                <p>Are you sure you want to delete this Challenge? This process cannot be undone</p>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="deleteComplaint();" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add challenge Modal -->
<div class="modal fade modalCss" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title text-center" id="exampleModalLabel">Add Challenge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="add_page_form">
                        @csrf
      <div class="modal-body">
            <div class="form-group">
        <label>Challenge Name</label>
           <input type="text" id="name" name="name" value="">
           </div>
      </div>
      <div class="modal-footer">
          
        <button type="button" class="btn btn-secondary nosecondary" data-dismiss="modal">Cancel</button>
        <input type="submit" name="submit" class="btn btn-primary addbtn">
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Edit challenge Modal -->
<div class="modal fade modalCss" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title text-center" id="exampleModalLabel">Edit Challenge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form id="update_page_form">
                        @csrf
      <div class="modal-body">
            <div class="form-group">
        <label>Challenge Name</label>
         <input type="hidden" id="cid" name="cid" value="">
           <input type="text" id="name1" name="name1" value="">
           </div>
      </div>
      <div class="modal-footer">
          
        <button type="button" class="btn btn-secondary nosecondary" data-dismiss="modal">Cancel</button>
        <input type="submit" name="submit" class="btn btn-primary updatebtn">
      </div>
    </form>
    </div>
  </div>
</div>
@endsection


@section('customScripts')
<script>

  $(document).on('click','.editchallg', function () {
  var cg_id = $(this).attr('data-id');
  var cname = $(this).attr('data-name');
  
  $("#cid").val(cg_id);
  $("#name1").val(cname);
});

    function checkId(deletedId) {
        $('#deleteID').val(deletedId);
    }

    function deleteComplaint() {
        var deletedId = $('#deleteID').val();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ url('delete-challenge') }}",
            data: {
                id: deletedId
            },
            dataType: 'json',
            success: function(data) {
                if (data.code == 200) {
                    $('#deletemodalcomplaints').hide();
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
    
    $(function() {

  $("#update_page_form").validate({
  // Specify validation rules

   
            rules: {
              name1: {
                    required: true,
                }
            },
            messages: {
                name1: "Please enter name",
            },
  submitHandler: function(form) {
    
     var formData = new FormData(form);
      $(".updatebtn").html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled','disabled');
        $.ajax({
            url: "{{ url('update-challenge') }}",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
              $(".updatebtn").html('Submit').removeAttr('disabled','disabled');
              console.log(result)
                if(result.code == 200){
                   $('#editModal').hide();
                    swal({
                        title: "",
                        text: result.message,
                        type: "success"
                    });
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                else{
                  alert('Error while updating challenge, please try later.');
                }
            }
        });
  }
  });
});


    $(function() {

  $("#add_page_form").validate({
  // Specify validation rules

   
            rules: {
              name: {
                    required: true,
                }
            },
            messages: {
                name: "Please enter name",
            },
  submitHandler: function(form) {
    
     var formData = new FormData(form);
      $(".addbtn").html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled','disabled');
        $.ajax({
            url: "{{ url('add-challenge') }}",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
              $(".updatebtn").html('Submit').removeAttr('disabled','disabled');
              console.log(result)
                if(result.code == 200){
                   $('#addModal').hide();
                  swal({
                        title: "",
                        text: result.message,
                        type: "success"
                    });
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                else{
                  alert('Error while add challenge, please try later.');
                }
            }
        });
  }
  });
});


</script>
@endsection