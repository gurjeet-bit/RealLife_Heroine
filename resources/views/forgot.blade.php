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
                    <h3>Forgot Password</h3>
                </div>
                 <form action="" method="post" id="admin-login">
                            @csrf
                    <div class="form-group">
                        <label class="control-label" for="emailaddress">Email address</label>
                                <input class="form-control" name="email" required="" type="email" value="" id="emailaddress"  placeholder="Enter your email">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary btn-block account-btn" id="sbtButton" type="submit">Submit</button>
                    </div>
                </form>
                <div class="text-center forgotpass mt-4"><a href="{{url('/')}}">Back To Login</a></div>
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


       $("#admin-login").validate({
        rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email : "Please enter a valid email"
                }
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
                url: "{{ url('forgotpassword') }}",
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
                          $("#admin-login").trigger('reset');
                    } else {
                         swal("", data.message, "error", {
                            button: "close",
                        });
                        // var errMsgs = '';
                        // for (var i = 0; i < data.errors.length; i++) {
                        //     var obj = data.errors[i];
                        //     errMsgs += obj + '</br>';
                        // }
                        
                        // var form = document.createElement("div");
                        // form.innerHTML = errMsgs;
                        
                        // swal({
                        //     icon: 'error',
                        //     title: '',
                        //     text: '',
                        //     content: form,
                        //     buttons: {
                        //       cancel: "Cancel"
                        //     }
                        // });
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