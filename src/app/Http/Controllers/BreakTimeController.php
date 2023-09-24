<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Date;
use App\Models\BreakTime;
use Carbon\Carbon;
use Auth;
use DB;

class BreakTimeController extends Controller
{
    public function breakIn(){
        $user=Auth::user();
        $oldDateIn=Date::where('user_id',$user->id)->latest()->first();
        $dateIn=BreakTime::where('user_id',$user->id)->latest()->first();
        if($oldDateIn->leave){
            return redirect()->back()->with('message','退勤済みです');
        }
        if(!empty($oldDateIn->attend) && empty($oldDateIn->leave) &&empty($dateIn->break_in)){
            $dateIn=BreakTime::create([
                'user_id'=>$user->id,
                'break_in'=>Carbon::now(),
            ]);
            return redirect()->back()->with('message','ゆっくりゆっくり休んでください');
        }elseif(!empty($dateIn->break_out)){
            $dateIn=BreakTime::create([
                'user_id'=>$user->id,
                'break_in'=>Carbon::now(),
            ]);
            return redirect()->back()->with('message','ゆっくり休んでください');
        }else{
            return redirect()->back()->with('message','休憩終了が打刻されていません');
        }
    }

    public function breakOut(){
        $user=Auth::user();
        $oldDateOut=Date::where('user_id',$user->id)->latest()->first();
        $dateOut=BreakTime::where('user_id',$user->id)->latest()->first();
        $breakIn=DB::table('breaktimes',$user->break_in)->latest()->get()->format('H:i:s');
        $breakOut=DB::table('breaktimes',$user->break_out)->latest()->get();
        $breakTime=strtoTime($breakOut)-strtoTime($breakIn);
        $hours=floor($breakTime/3600);
        $minutes=floor(($breakTime%3600)/60);
        $seconds=$breakTime%60;
        $hms=sprintf("%02d:%02d:%02d",$hours,$minutes,$seconds);
        if(empty($dateOut->break_in)){
            return redirect()->back()->with('message','休憩開始が打刻されていません');
        }
        if($dateOut->break_in && empty($dateOut->break_out)){
            $dateOut->update([
                'break_out'=>Carbon::now(),
            ]);
            $oldDateOut->update([
                'break_total'=>$hms
            ]);
            return redirect()->back()->with('message','引き続きよろしくお願いします!');
        }else{
            return redirect()->back()->with('message','休憩開始が打刻されていません');
        }
    }
}
