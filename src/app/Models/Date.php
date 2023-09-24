<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $fillable=['user_id','attend','leave','break_total','work_time'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function breakTimes(){
        return $this->hasMany('App\Models\BreakTime');
    }
}
