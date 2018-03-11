<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['name'];

    /**
     * Checks if a venue has been assigned at a given day and period
     *
     * @param $day
     * @param $period
     * @return mixed
     */
    public function hasBeenAssignedOn($day, $period)
    {
        return $this->where(['day' => $day, 'time' => $period])->exists();
    }

    /**
     * Mark a venue as assigned
     *
     * @param $course_id
     * @param $day
     * @param $period
     * @return mixed
     */
    public function markAsAssignedOn($course_id, $day, $period)
    {
        return $this->where('id', $this->id)->update(
            ['is_in_use' => true, 'course_id' => $course_id, 'day' => $day, 'time' => $period]
        );
    }

    /**
     * Returns venues in use
     *
     * @return mixed
     */
    public function inUse()
    {
        return $this->where('is_in_use', TRUE);
    }
}
