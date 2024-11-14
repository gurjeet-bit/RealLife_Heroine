@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-12">
                    <h3 class="page-title">Welcome {{ Session::get('real_name') }}!</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12">
                <a href="{{url('users')}}">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="dash-widget-info">
                                <h3>{{ $userCount }}</h3>
                                <h6 class="text-muted">Users</h6>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('courses')}}">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="fas fa-city"></i>
                            </span>
                            <div class="dash-widget-info">
                                <h3>{{ $coursesCount }}</h3>
                                <h6 class="text-muted">Courses</h6>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('blogs')}}">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                               <i class="fas fa-blog" style="color: #ffffff;"></i>
                            </span>
                            <div class="dash-widget-info">
                                <h3>{{ $blogsCount }}</h3>
                                <h6 class="text-muted">Blogs</h6>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('podcasts')}}">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="fas fa-podcast"></i>
                            </span>
                            <div class="dash-widget-info">
                                <h3>{{ $podcastsCount  }}</h3>
                                <h6 class="text-muted">Podcasts</h6>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
               <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('videos')}}">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon bg-primary">
                                <i class="fas fa-video"></i>
                            </span>
                            <div class="dash-widget-info">
                                <h3>{{ $videosCount  }}</h3>
                                <h6 class="text-muted">Videos</h6>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Recent Orders -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title">Recent Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($users) > 0)
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                         <td><img style="height: 70px!important;width: 70px!important;object-fit: cover!important;" class="rounded-circle img-thumbnail" src="{{ url('/public/assets/image/profile')}}/{{ $user->image  == '' ? 'default-profile-img.png' : $user->image}}" id="profile_img_id"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status == 1 ? 'Active' :  'Block' }}</td>
                                        <td>
                                            <a href="{{ url('/view-user') }}/{{ $user->id }}" class="btn btn-sm bg-info-light">
                                                <i class="far fa-eye mr-1"></i>
                                            </a>
                                            <!--<a href="{{ url('/edit-complaint') }}/{{ $user->id }}" class="btn btn-sm bg-success-light">-->
                                            <!--    <i class="far fa-edit mr-1"></i>-->
                                            <!--</a>-->
                                            <!--<a href="javscript:void(0);" onclick="checkId('{{ $user->id }}')" data-toggle="modal" data-target="#deletemodalcomplaints" class="btn btn-sm bg-danger-light delete_review_comment">-->
                                            <!--    <i class="far fa-trash-alt"></i>-->
                                            <!--</a>-->
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No Users Found.</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Of Recent Orders -->

            <!-- Products -->
            <!--<div class="col-md-12">-->
            <!--    <div class="card card-table flex-fill">-->
            <!--        <div class="card-header">-->
            <!--            <h4 class="card-title">Complaints</h4>-->
            <!--        </div>-->
            <!--        <div class="card-body p-4">-->
            <!--            <div id="productservices" style="min-height: 415px;"></div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- End Of Products -->

        </div>
    </div>
</div>
</div>

@endsection

