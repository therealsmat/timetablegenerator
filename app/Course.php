<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'units', 'code', 'dept', 'session', 'semester', 'level','lecturer'];
}
