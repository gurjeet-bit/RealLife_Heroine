@extends('layouts.app')
@section('content')

<style>
    .main-wrapper {
        padding: 0;
    }
</style>
<div class="login-page">
    <div class="login-body container">
        <div class="loginbox">
            <div class="login-right-wrap">
                <div class="account-header">
                    <!--<div class="account-logo text-center mb-4">-->
                    <!--    <a href="index.html">-->
                    <!--        <img src="{{ asset('img/logo.png') }}" alt="" class="img-fluid">-->
                    <!--    </a>-->
                    <!--</div>-->
                </div>
                <div class="login-header text-center">
                    <h3>Login</h3>
                </div>
                 <form action="" method="post" id="admin-login">
                            @csrf
                    <div class="form-group">
                        <label class="control-label" for="emailaddress">Email address</label>
                                <input class="form-control" name="email" required="" type="email" value="" id="emailaddress"  placeholder="Enter your email">
                    </div>
                    <div class="form-group mb-4">
                        <label class="control-label">Password</label>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="password" name="password" value="" required="" id="password" class="form-control" placeholder="Enter your password">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary btn-block account-btn" id="sbtButton" type="submit">Login</button>
                    </div>
                </form>
                <div class="text-center forgotpass mt-4"><a href="{{url('/forgot-password')}}">Forgot Password?</a></div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('customScripts')

<script>
            @if(Session::has('success'))
                $(function () {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "10000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success("{{ Session::get('success') }}");
                });
            @endif    
            @if(Session::has('error'))
                $(function () {
                    toastr.options = {
                      "closeButton": true,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": false,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "10000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    };
                    toastr.error("{{ Session::get('error') }}");
                });
            @endif  
        </script>
        
<script type="text/javascript">
    $(document).ready(function(){
        $('#admin-login').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password:{
                    required:true,
                    maxlength:50,
                    // minlength:6
                },
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email : "Please enter a valid email"
                },
                password:{
                    required:"Please enter password",
                },
            },
             submitHandler: function(form) {
            
            var form2 = $('#admin-login')[0];
            var serializedData = new FormData(form2);
        
            $('#sbtButton').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ url('login1') }}",
                data: serializedData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                dataType: 'json',
                success: function(data) {
                    $('#sbtButton').html('Login');
                    

                    if (data.code == 200) {
                        
                        swal("", data.message, "success", {
                            button: "close",
                        });
                          $("#admin-login").trigger('reset');
                          window.location.href = _baseURL+'/dashboard';
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

    // $(document).on('click','#password-eye',function(){
    //     $(this).toggleClass("fa-eye fa-eye-slash");
    //       var input = $('#password');
    //     if (input.attr("type") == "password") {
    //       input.attr("type", "text");
    //     } else {
    //       input.attr("type", "password");
    //     }
    // });
</script>
@endsection