<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Date;
use App\Models\BreakTime;
use Carbon\Carbon;
use Auth;

class AuthenticatedSessionController extends Controller
{
    public function index(){
        return view('stamp');
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
            return redirect()->back()->with('message','出勤打刻は1日1回です');
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
        if($dateOut){
            if(empty($dateOut->leave)){
                if(!empty($breakTime->break_in) && empty($breakTime->break_out)){
                    return redirect()->back()->with('message','休憩終了が打刻されていません');
                }else{
                    $dateOut->update([
                        'leave'=>Carbon::now(),
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