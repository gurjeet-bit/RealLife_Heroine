<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>RealLife Heroine</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/admin.css">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="{{ url('/') }}" class="logo logo-small">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30" height="30">
                </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-align-left"></i>
            </a>
            <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
                <i class="fas fa-align-left"></i>
            </a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown noti-dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="far fa-bell"></i> <span class="badge badge-pill"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="/">
                                        <div class="media">
                                            <span class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" alt="" src="{{ asset('img/avatar1.png') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details">
                                                    <span class="noti-title">Vincent Porter</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="/">
                                        <div class="media">
                                            <span class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" alt="" src="{{ asset('img/avatar2.png') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details">
                                                    <span class="noti-title">Vincent Porter</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="/">
                                        <div class="media">
                                            <span class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" alt="" src="{{ asset('img/avatar3.png') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details">
                                                    <span class="noti-title">Vincent Porter</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="/">
                                        <div class="media">
                                            <span class="avatar avatar-sm">
                                                <img class="avatar-img rounded-circle" alt="" src="{{ asset('img/avatar7.png') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details">
                                                    <span class="noti-title">Vincent Porter</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="notifications.php">View all Notifications</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="assets/img/user.png" width="40" alt="">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="login.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>