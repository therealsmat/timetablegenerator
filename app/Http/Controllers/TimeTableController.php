<?php

namespace App\Http\Controllers;

use App\Course;
use App\TimeTable;
use App\TimeTableGenerator;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    public function generate(Course $course, TimeTable $table)
    {
        $condition = request()->all();

        $courses = $course->where($condition)->get()->toArray();

        try{
            $timeTable =  new TimeTableGenerator($courses);
            $timeTable = $timeTable->generate();

            if ($table->alreadyHas($condition)) {
                $table->where($condition)->update(['schedule' => json_encode($timeTable) ]);
            } else {
                $table->create([
                    'dept'          => $condition['dept'],
                    'level'         => $condition['level'],
                    'semester'      => $condition['semester'],
                    'session'       => $condition['session'],
                    'schedule'      => json_encode($timeTable)
                ]);
            }
            return redirect()->route('timetable.index', $condition);
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function index(Request $request, TimeTable $table)
    {
        $condition = $request->all();

        $timeTable = $table->where($condition)->first();

        $schedule = json_decode($timeTable->schedule);

        $daysLabel = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $condition['semester'] = $condition['semester'] == 1 ? '1st' : '2nd';

        return view('timetable', compact('schedule', 'condition', 'daysLabel'));

    }
}
