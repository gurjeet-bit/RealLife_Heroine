@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Add Assignments</h4>
                        <a href="{{ url('assignments') }}" class="btn btn-default btnwhite">Back To Assignments</a>
                    </div>
                    <div class="card-body assignmentbody">
                        <div class="padBox">

                            <form method="POST" action="" id="editcommunityForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title" class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                      <div id="builder"></div> 
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
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
<script src="https://cdn.form.io/formiojs/formio.full.min.js"></script>

<script>

Formio.builder(document.getElementById('builder'), {}, {
    noDefaultSubmitButton: true,
  builder: {
    basic: false,
    advanced: false,
    data: false,
    customBasic: {
      title: 'Basic Components',
      default: true,
      weight: 0,
      components: {
        textfield: true,
        textarea: true,
        email: true,
        phoneNumber: true
      }
    },
    custom: {
      title: 'Pre-Defined Fields',
      weight: 10,
      components: {
        firstName: {
          title: 'First Name',
          key: 'firstName',
          icon: 'terminal',
          schema: {
            label: 'First Name',
            type: 'textfield',
            key: 'firstName',
            input: true
          }
        },
        lastName: {
          title: 'Last Name',
          key: 'lastName',
          icon: 'terminal',
          schema: {
            label: 'Last Name',
            type: 'textfield',
            key: 'lastName',
            input: true
          }
        },
        email: {
          title: 'Email',
          key: 'email',
          icon: 'at',
          schema: {
            label: 'Email',
            type: 'email',
            key: 'email',
            input: true
          }
        },
        phoneNumber: {
          title: 'Mobile Phone',
          key: 'mobilePhone',
          icon: 'phone-square',
          schema: {
            label: 'Mobile Phone',
            type: 'phoneNumber',
            key: 'mobilePhone',
            input: true
          }
        }
      }
    },
    layout: {
      components: {
        table: false
      }
    }
  },
  editForm: {
    textfield: [
      {
        key: 'api',
        ignore: true
      }        
    ]
  }
}).then(function(form) {
     form.on("change", function(e){
         var jsonSchema = JSON.stringify(form.schema, null, 4);
    console.log('my codes--' ,jsonSchema);
  });
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
           var form2 = $('#editcommunityForm')[0];
            var serializedData = new FormData(form2);
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('insertassignment') }}",
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
                          $("#editcommunityForm").trigger('reset');
                            window.location.href = _baseURL+'/assignments';

                          //  window.setTimeout(function() {
                          // location.reload();
                          //  }, 3000);
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