<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Date;
use App\Models\BreakTime;
use Carbon\Carbon;
use Auth;
use DB;

class AuthenticatedSessionController extends Controller
{
    public function index(){
        $user=Auth::user();
        $newDate=DB::table('dates')->where('user_id',$user->id)->latest()->first();
        $newBreakTime=DB::table('breaktimes')->where('user_id',$user->id)->latest()->first();
        $attend=optional($newDate)->attend;
        $leave=optional($newDate)->leave;
        $breakIn=optional($newBreakTime)->break_in;
        $breakOut=optional($newBreakTime)->break_out;
        if(!empty($leave)){
            return view('stamp.attend');
        }
        if(!empty($attend)){
            if(!empty($breakIn)&&empty($breakOut)){
                return view('stamp.breakOut');
        }else{
            return view('stamp.leave_or_breakIn');
        }
        }
        return view('stamp.attend');
    }

    public function attend(){
        $user=Auth::user();
        $oldDateIn=Date::where('user_id',$user->id)->latest()->first();
        $today=Carbon::today();
        $oldDay='';
        if($oldDateIn) {
            $oldDateAttend=new Carbon($oldDateIn->attend);
            $oldDay=$oldDateAttend->startOfDay();
        }
        if($oldDay==$today){
            return redirect()->back()->with('message','出勤打刻は1日1回です');
        }
        $dateIn=Date::create([
            'user_id'=>$user->id,
            'attend'=>Carbon::now(),
            ]);
        return redirect()->back()->with('message','今日も1日よろしくお願いします!');
    }

    public function leave(){
        $user=Auth::user();
        $dateOut=Date::where('user_id',$user->id)->latest()->first();
        $breakTime=BreakTime::where('user_id',$user->id)->latest()->first();
        $today=Carbon::today();

        $breaksIn=DB::table('breaktimes')->where('user_id',$user->id)->whereDate('break_in',$today)->pluck('break_in');
        $breakInTotal=0;
        foreach($breaksIn as $breakIn){
            $breakInTime=new Carbon($breakIn);
            $breakInDecimal=strtoTime($breakInTime);
            $breakInTotal+=$breakInDecimal;
        }

        $breaksOut=DB::table('breaktimes')->where('user_id',$user->id)->whereDate('break_out',$today)->pluck('break_out');
        $breakOutTotal=0;
        foreach($breaksOut as $breakOut){
            $breakOutTime=new Carbon($breakOut);
            $breakOutDecimal=strtoTime($breakOutTime);
            $breakOutTotal+=$breakOutDecimal;
        }

        $breakTime=$breakOutTotal-$breakInTotal;
        $breakHours=floor($breakTime/3600);
        $breakMinutes=floor(($breakTime%3600)/60);
        $breakSeconds=$breakTime%60;
        $breakHms=sprintf("%02d:%02d:%02d",$breakHours,$breakMinutes,$breakSeconds);

        $attend=DB::table('dates')->where('user_id',$user->id)->latest()->value('attend');
        $attendTime=new Carbon($attend);
        $attendDecimal=strtoTime($attendTime);

        $leave=Carbon::now();
        $leaveDecimal=strtoTime($leave);

        $workTotal=$leaveDecimal-$attendDecimal;
        $workTime=$workTotal-$breakTime;

        $workHours=floor($workTime/3600);
        $workMinutes=floor(($workTime%3600)/60);
        $workSeconds=$workTime%60;
        $workHms=sprintf("%02d:%02d:%02d",$workHours,$workMinutes,$workSeconds);

        $dateOut->update([
        'leave'=>Carbon::now(),
        'break_total'=>$breakHms,
        'work_time'=>$workHms
        ]);
        return redirect()->back()->with('message','気をつけてお帰りください!');
        }
}