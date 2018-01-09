@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">
                        <h4 class="text-center" style="text-transform: uppercase">
                            <strong>{{ $condition['semester'] }} Semester TimeTable</strong>
                        </h4>
                    </div>

                    <div class="panel-body">

                        @if(count($schedule))
                            <table class="table table-responsive table-striped table-bordered">
                                <tr>
                                    <th></th>
                                    <th>8 - 9</th>
                                    <th>9 - 10</th>
                                    <th>10 - 11</th>
                                    <th>11 - 12</th>
                                    <th>12 - 1</th>
                                    <th>1 - 2</th>
                                    <th>2 - 3</th>
                                    <th>3 - 4</th>
                                    <th>4 - 5</th>
                                </tr>

                                @foreach($schedule as $day)
                                    <tr>
                                        <td>{{ $daysLabel[$loop->index] }}</td>
                                        @foreach($day as $item)
                                            <td>{{ $item }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>

                        @else
                            <p class="text-center text-danger">No schedule available</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection