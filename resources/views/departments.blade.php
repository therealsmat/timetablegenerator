@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">Departments
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </button>
                    </div>

                    <div class="panel-body">
                        @if(count($departments))
                            <table class="table table-responsive table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                @foreach($departments as $department)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>
                                            <form action="{{ route('department.remove', $department->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-link">remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-center text-danger">No departments available</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form action="{{ route('department.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">New Course</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Description</label>
                                        <textarea type="text" class="form-control" rows="4" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary">Save Department</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection