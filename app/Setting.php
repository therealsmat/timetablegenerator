<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public function getByKey($key)
    {
        return $this->where('key', $key)->first()->value;
    }
}
