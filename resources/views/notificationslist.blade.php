@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Notifications</h4>
                    </div>
                    <div class="card-body">
                        <div class="viewBox notification">
                            <div class="people-list">
                                <ul class="list-unstyled chat-list mt-0 mb-0">

                                    @if(count($notifications) > 0)
                                    @foreach($notifications as $notification)
                                    <li class="clearfix">

                                        <div class="about">
                                            <div class="name">
                                                @if($notification->type == 1)
                                                Complaint
                                                @elseif($notification->type == 3)
                                                Community Change Request
                                                @elseif($notification->type == 4)
                                                Pickup Person
                                                @else
                                                User Registerd
                                                @endif </div>
                                            <div class="message">{{ $notification->content }}</div>
                                        </div>
                                        <div class="date-time text-right">
                                            <div class="time"><i class="far fa-clock"></i> {{ show_time_ago($notification->created_at) }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @else
                                    <li class="clearfix">
                                        <p> No New Notifications Found.</p>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Of Users -->
        </div>
    </div>
</div>

@endsection