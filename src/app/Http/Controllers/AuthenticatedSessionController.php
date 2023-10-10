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
        $today=Carbon::today();
        $attend=DB::table('dates')->where('user_id',$user->id)->whereDate('attend',$today)->first();
        $leave=DB::table('dates')->where('user_id',$user->id)->whereDate('leave',$today)->first();
        $breakIn=DB::table('breaktimes')->where('user_id',$user->id)->latest()->value('break_in');
        $breakOut=DB::table('breaktimes')->where('user_id',$user->id)->latest()->value('break_out');
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
        $oldDateInDay='';
        if($oldDateIn){
            $oldDateInPunchIn=new Carbon($oldDateIn->attend);
            $oldDateInDay=$oldDateInPunchIn->startOfDay();
        }
        $newDateInDay=Carbon::today();
        if(($oldDateInDay==$newDateInDay)&&(empty($oldDateIn->leave))){
        }
        
        if($oldDateIn){
            $oldDatePunchOut=new Carbon($oldDateIn->leave);
            $oldDateInDay=$oldDatePunchOut->startOfDay();
        }

        if(($oldDateInDay==$newDateInDay)){
            return redirect()->back()->with('message','退勤済みです');
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

        $attend=DB::table('dates')->where('user_id',$user->id)->whereDate('attend',$today)->value('attend');
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

        if($dateOut){
            if(empty($dateOut->leave)){
                if(!empty($breakTime->break_in) && empty($breakTime->break_out)){
                    return redirect()->back()->with('message','休憩終了が打刻されていません');
                }else{
                    $dateOut->update([
                        'leave'=>Carbon::now(),
                        'break_total'=>$breakHms,
                        'work_time'=>$workHms
                    ]);
                    return redirect()->back()->with('message','気をつけてお帰りください!');
                }
            }else{
                $today=new Carbon();
                $day=$today->day;
                $oldPunchOut=new Carbon();
                $oldPunchDay=$oldPunchOut->day;
                if($day==$oldPunchDay){
                    return redirect()->back()->with('message','退勤済みです');
                }
            }
        }else{
            return redirect()->back()->with('message','出勤打刻がされていません');
        }
    }
}