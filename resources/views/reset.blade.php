@extends('layouts.app')
@section('content')

<style>
    .main-wrapper {
        padding: 0;
    }
</style>
           <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">
                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <!--<div class="auth-logo">-->
                                    <!--    <a href="{{url('/admin/login')}}" class="logo logo-dark text-center">-->
                                    <!--        <span class="logo-lg">-->
                                    <!--            <img src="{{asset('admin/images/logo.png')}}" alt="" height="45">-->
                                    <!--        </span>-->
                                    <!--    </a>-->

                                    <!--    <a href="{{url('/admin/login')}}" class="logo logo-light text-center">-->
                                    <!--        <span class="logo-lg">-->
                                    <!--            <img src="{{asset('admin/images/logo.png')}}" alt="" height="22">-->
                                    <!--        </span>-->
                                    <!--    </a>-->
                                    <!--</div>-->
                                    <h3 class="text-muted mb-4 mt-3">Reset Password</h3>
                                </div>
                                
                                <form action="" id="admin-forget-password" method="post">
                                    @csrf
                                        <div class="form-group floating-label col-md-12">
                                            <label>Password</label>
                                            <input type="password" name="new_pw" id="new_pw" class="form-control" value="" placeholder="Password">
                                        </div>
                                        <div class="form-group floating-label col-md-12">
                                            <label>Confirm Password</label>
                                            <input type="password" name="confirm_pw" class="form-control" value="" placeholder="Confirm Password">
                                        </div>
                                        <button type="submit" id="sbtButton" class="btn btn-primary btn-block btn-lg btn-primary-theme">Submit</button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end row -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        <!--</div>-->


    <div class="rightbar-overlay"></div>

@endsection
@section('customScripts')
<script type="text/javascript">
$(document).ready(function(){
    console.log('htrtrtr');
   
    
      $("#admin-forget-password").validate({
         rules:{
            new_pw:{
                required: true,
                minlength:6,
            },
            confirm_pw:{
                required  : true,
                minlength :6,
                equalTo   : "#new_pw",
            },
        },
        messages:{
             new_pw:{
                required: 'Please enter new password'
            },
            confirm_pw:{
                equalTo:"Confirm password is not same. Please enter again"
            }
        },
        submitHandler: function(form) {
            
            var form2 = $('#admin-forget-password')[0];
            var serializedData = new FormData(form2);
        
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('change-password') }}",
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
                          $("#admin-forget-password").trigger('reset');
                          window.location.href = _baseURL+'/';
                    } else {
                         swal("", data.message, "error", {
                            button: "close",
                        });
                    }


                }
            });
            return false;
        }
    });
    
});


</script>
@endsection