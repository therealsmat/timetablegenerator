@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">Levels
                        @if(count($courses))
                            <a href="/generate?dept=0&level={{ request('level') }}&semester={{ request('sem') }}&session={{ request('sess') }}"
                               class="btn btn-success pull-right" style="margin-right:5px;">
                                <i class="glyphicon glyphicon-tasks"></i> Generate Time Schedule
                            </a>
                            <a href="/time-table?level={{ request('level') }}&semester={{ request('sem') }}&session={{ request('sess') }}"
                               class="btn btn-info pull-right" style="margin-right:5px;">
                                <i class="glyphicon glyphicon-eye-open"></i> View Schedule
                            </a>
                        @endif
                        <button class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal2" style="margin-right: 5px;">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </button>&nbsp;
                    </div>

                    <div class="panel-body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="level">Level</label>
                                        <select name="level" id="level" class="form-control">
                                            @for($x = 100; $x <= 700; $x += 100)
                                                <option value="{{ $x }}" {{ request('level') == $x ? 'SELECTED' : '' }}>{{ $x }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="semester">Semester</label>
                                        <select name="sem" id="semester" class="form-control">
                                            <option value="1" {{ request('sem') == 1 ? 'SELECTED' : '' }}>1st</option>
                                            <option value="2" {{ request('sem') == 2 ? 'SELECTED' : '' }}>2nd</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="semester">Session</label>
                                        <input type="text" name="sess" class="form-control" value="2017/2018">
                                        <input type="hidden" name="dept" class="form-control" value="0">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-success">Apply!</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <hr>

                        @if(count($courses))
                            <table class="table table-responsive table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Course Title</th>
                                    <th class="text-center">Course Code</th>
                                    <th class="text-center">Units</th>
                                    <th>Lecture Time</th>
                                    <th>Lecturer</th>
                                </tr>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="#">{{ strtoupper($course->title) }}</a></td>
                                        <td class="text-center"><code>{{ $course->code }}</code></td>
                                        <td class="text-center">{{ $course->units }}</td>
                                        <td class="text-center"><code>{{ $course->units }}hrs</code></td>
                                        <td>{{ 'NIL' }}</td>
                                    </tr>
                                @endforeach
                            </table>

                        @else
                            <p class="text-center text-danger">No courses available</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form action="{{ route('course.store') }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">New Course</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Course Title</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">Course Code</label>
                                        <input type="text" class="form-control" name="code">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="title">Units</label>
                                        <input type="number" class="form-control" min="0" name="units">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">Level</label>
                                        <select name="level" id="level" class="form-control">
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                            <option value="600">600</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">Semester</label>
                                        <select name="semester" id="semester" class="form-control">
                                            <option value="1">1st</option>
                                            <option value="2">2nd</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="title">Session</label>
                                        <input type="text" class="form-control" value="2017/2018" name="session">
                                        <input type="hidden" name="general" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection