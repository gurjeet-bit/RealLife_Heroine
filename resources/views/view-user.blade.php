@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <!-- Users -->
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">View User</h4>
                        <a href="{{ url('users') }}" class="btn btn-default btnwhite">Back To Users</a>
                    </div>
                    <div class="card-body">
                        <div class="viewBox">
                            <table class="table table-bordered">
                                <tr>
                                    <th> Name </th>
                                    <td> {{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th> Email Address </th>
                                    <td> {{ $user->email }} </td>
                                </tr>
                              
                                 <tr>
                                    <th> Profile Image </th>
                                    <td>
                                        @if($user->image != "")
                                        <img src="{{ url('/') }}/public/assets/image/profile/{{ $user->image }}" style="height: 250px;width: 250px;object-fit: contain;" ></img>
                                        @else
                                        <p>-NA-</p>
                                        @endif
                                    </td>
                                </tr>
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