<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    protected $fillable = ['dept', 'level' ,'semester' ,'session' ,'schedule'];

    public function alreadyHas($condition)
    {
        return $this->where($condition)->exists();
    }
}
