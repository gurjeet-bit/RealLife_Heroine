@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">View Contact Query</h4>
                        <a href="{{ url('contacts') }}" class="btn btn-default btnwhite">Back To Contact Queries</a>
                    </div>
                    <div class="card-body">
                        <div class="viewBox">

                            <table class="table table-bordered">
                                <tr>
                                    <th> User Name </th>
                                    <td> {{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th> User Email </th>
                                    <td> {{ $user->email }} </td>
                                </tr>
                                <tr>
                                    <th> Query </th>
                                    <td> {{ $query->query }} </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection