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
        if(empty($dateOut->break_in)){
            return redirect()->back()->with('message','休憩開始が打刻されていません');
        }
        if($dateOut->break_in && empty($dateOut->break_out)){
            $dateOut->update([
                'break_out'=>Carbon::now(),
            ]);
            return redirect()->back()->with('message','引き続きよろしくお願いします!');
        }else{
            return redirect()->back()->with('message','休憩開始が打刻されていません');
        }
    }
}
