@extends('layouts.app')

@section('content')
<style>
    .dataTables_filter{ display: none; }
    .dataTables_length{ display: none; }
    </style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            @php $i = 1; @endphp
            @foreach($coursesLs as $course)
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{$course['title']}} <span class="badge badge-pill {{$course['is_course_completed'] == false ? 'badge-danger' : 'badge-success'}} badge-danger pendingHeading">{{$course['is_course_completed'] == false ? 'Pending' : 'Completed'}}</span></h4>
                        @if($i == 1)
                        <a href="{{ url('users') }}" class="btn btn-default btnwhite">Back To Courses</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="padBox accord_new">
                            <div class="accordion" id="accordionExample">
                            @foreach($course['newModule'] as $module)
                              <div class="card">
                                <div class="card-header" id="headingOne">
                                  <h2 class="mb-0 d-flex align-items-center justify-content-between">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                     {{$module->name}}
                                    </button>

                                    <span class="badge badge-pill {{$module->is_module_completed == false ? 'badge-danger' : 'badge-success'}} compleHeading">{{$module->is_module_completed == false ? 'Pending' : 'Completed'}}</span> 
                                  </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                  <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No</th>
                                                    <th>Name</th>
                                                    <th>Progress</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $count = 1; @endphp
                                            @foreach($module->lesson_detail as $lesson)
                                                <tr> 
                                                    <td>{{$count}}</td>
                                                    <td>{{$lesson->title}}</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-dark">{{$lesson->percentage}}%</span> 
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill {{$lesson->percentage == 100 ? 'badge-success' : 'badge-danger'}}">{{$lesson->percentage == 100 ? 'Completed' : 'Pending'}}</span> 
                                                    </td>
                                                </tr>
                                            @php $count += 1; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php $i += 1; @endphp
            @endforeach
            <!-- End Of Users -->
        </div>
    </div>
</div>

@endsection