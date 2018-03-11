@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">Venues
                        <button class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal2" style="margin-right: 5px;">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </button>&nbsp;
                    </div>

                    <div class="panel-body">
                        @if(count($venues) > 0)
                            <table class="table table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Hall Name</th>
                                    <th>Status</th>
                                </tr>

                                @foreach($venues as $venue)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $venue->name }}</td>
                                        <td>
                                            @if($venue->is_in_use)
                                                <span class="label label-danger">taken</span>
                                            @else
                                                <span class="label label-success">free</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form action="{{ route('venue.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">New Venue</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <label for="title">Hall Name</label>
                                        <input type="text" class="form-control" name="name">
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