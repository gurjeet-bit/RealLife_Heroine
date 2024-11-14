<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>RealLife Heroine Admin</title>
    <link rel="shortcut icon" href="{{ asset('img/reallifeicon.png') }}">
  <!--   <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}"> --> 
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.min.css') }}">
   <link rel="stylesheet" href="https://cdn.form.io/formiojs/formio.full.min.css">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var _baseURL = '{{ url('/') }}';
    </script>
</head>

<body>
    <div class="main-wrapper">
        @if(Session::get('real_email'))
        <div class="header">
           <!--<div class="header-left">-->
           <!--     <a href="{{ url('/') }}" class="logo logo-small">-->
           <!--         <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30">-->
           <!--     </a>-->
           <!-- </div>-->
              <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-align-left"></i>
            </a>
            <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
                <i class="fas fa-align-left"></i>
            </a>
        </div>
    </div>
    <ul class="nav user-menu">
    <li class="nav-item dropdown">
        <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
            <span class="user-img">
                <img id="p_image" class="rounded-circle" src="{{ url('/public/assets/image/profile')}}/{{ Session::get('real_image')  == '' ? 'default-profile-img.png' : Session::get('real_image')}}" width="40" alt="">
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ url('/edit-profile') }}">Profile</a>
            <a class="dropdown-item" href="{{ url('/login') }}">Logout</a>
        </div>
    </li>
    </ul>
    </div>

    @endif