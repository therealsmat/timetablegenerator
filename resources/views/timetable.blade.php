@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">
                        <h4 class="text-center" style="text-transform: uppercase">
                            {{ strtoupper($institution) }}<br><br>
                            <strong>{{ $condition['semester'] }} Semester TimeTable</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-success" onclick="printElem()">Print</button>
                        </h4>
                    </div>

                    <div class="panel-body" id="printArea">

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
                                            <td>
                                                <strong>{{ $item }}</strong><br>
                                                <small>{!! optional($venues)[$item] !!}</small>
                                            </td>
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

    <script>
        function printElem() {
            var content = document.getElementById('printArea').innerHTML;
            var mywindow = window.open('', 'Print', 'height=900,width=800');

            mywindow.document.write('<html><head><title>Print</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write("<span style=\"text-align:center;\">{{ $institution }}</span>");
            mywindow.document.write(content);
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            mywindow.close();
            return true;
        }
    </script>
@endsection