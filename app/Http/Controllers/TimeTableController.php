<?php

namespace App\Http\Controllers;

use App\Course;
use App\Setting;
use App\TimeTable;
use App\TimeTableGenerator;
use App\Venue;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    public function generate(Course $course, TimeTable $table)
    {
        $condition = request()->all();
        if (!isset($condition['dept'])) $condition['dept'] = 0;

        $courses = $course->where($condition)->get()->toArray();

        $levelWideCourses = null;
        $newCondition = $condition;
        $newCondition['dept'] = 0;
        if ($table->alreadyHas($newCondition)) {
           $levelWideCourses = $table->where($newCondition)->first()->schedule;
        }

        try{
            $timeTable =  new TimeTableGenerator($courses);
            $timeTable->levelWideCourse(json_decode($levelWideCourses, true));
            $timeTable = $timeTable->generate($condition['dept']);

            if ($table->alreadyHas($condition)) {
                $table->where($condition)->update(['schedule' => json_encode($timeTable) ]);
            } else {
                $table->create([
                    'dept'          => $condition['dept'] ?? 0,
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

    public function index(Request $request, TimeTable $table, Venue $venue)
    {
        $condition = $request->all();

        $timeTable = $table->where($condition)->first();

        $schedule = json_decode($timeTable->schedule);

        $venues = $venue->inUse()->get();

        $venues = collect($venues)->reduce(function ($parsed, $venues) {
            $parsed[$venues['course_id']] = "<span class='badge'>{$venues['name']}</span>";
            return $parsed;
        });

        $daysLabel = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $condition['semester'] = $condition['semester'] == 1 ? '1st' : '2nd';


        $institution = (new Setting())->getByKey('institution_name');

        return view('timetable', compact('schedule', 'condition', 'daysLabel', 'venues', 'institution'));
    }
}
