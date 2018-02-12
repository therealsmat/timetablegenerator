@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">
                        <strong>Settings</strong>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('settings.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="institute_name">Institution Name</label>
                                <input type="text" class="form-control" id="institute_name" name="institution_name">
                            </div>
                            <hr>
                            <div class="form-group form-inline">
                                <label for="break_time">Breaktime</label>
                                <select name="break_time" id="" class="form-control">
                                    @for($x = 0; $x < 9; $x++)
                                        <option value="{{ $x }}">{{ $x + 8 }}: 00</option>
                                    @endfor
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection