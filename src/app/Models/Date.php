<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class Date extends Model
{
    use HasFactory;

    protected $fillable=['user_id','attend','leave','break_total','work_time','updated_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function breakTimes(){
        return $this->hasMany('App\Models\BreakTime');
    }

    public function getAttend(){
        $date=$this->attend;
        $attend=new Carbon($date);
        $hour=$attend->hour;
        $minute=$attend->minute;
        $second=$attend->second;
        $hms=sprintf("%02d:%02d:%02d",$hour,$minute,$second);
        return $hms;
    }

    public function getLeave(){
        $date=$this->leave;
        $leave=new Carbon($date);
        $hour=$leave->hour;
        $minute=$leave->minute;
        $second=$leave->second;
        $hms=sprintf("%02d:%02d:%02d",$hour,$minute,$second);
        return $hms;
    }

}
