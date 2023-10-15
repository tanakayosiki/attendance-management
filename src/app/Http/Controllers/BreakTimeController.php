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
        }
    }

    public function breakOut(){
        $user=Auth::user();
        $oldDateOut=Date::where('user_id',$user->id)->latest()->first();
        $dateOut=BreakTime::where('user_id',$user->id)->latest()->first();
        if($dateOut->break_in && empty($dateOut->break_out)){
            $dateOut->update([
                'break_out'=>Carbon::now(),
            ]);
            return redirect()->back()->with('message','引き続きよろしくお願いします!');
        }
    }
}
