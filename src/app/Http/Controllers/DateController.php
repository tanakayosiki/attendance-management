<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Date;
use App\Models\BreakTime;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DateController extends Controller
{
    public function index(){
        $user=Auth::user();
        $date=Carbon::today();
        $year=$date->year;
        $month=$date->month;
        $day=$date->day;
        $ymd=sprintf("%d-%02d-%02d",$year,$month,$day);
        $users=Date::with('user')->whereDate('updated_at',$ymd)->paginate(5);
        return view('date',compact('users','ymd'));
    }

    public function back(Request $request){
        $user=Auth::user();
        $data=$request->all();
        $now=optional($data)["ymd"];
        $date=new Carbon($now);
        $back=$date->subDay(1);
        $year=$back->year;
        $month=$back->month;
        $day=$back->day;
        $ymd=sprintf("%d-%02d-%02d",$year,$month,$day);
        $users=Date::with('user')->whereDate('updated_at',$ymd)->paginate(5);
        return view('date',compact('users','ymd'));
    }

    public function forward(Request $request){
        $user=Auth::user();
        $data=$request->all();
        $now=optional($data)["ymd"];
        $date=new Carbon($now);
        $forward=$date->addDay(1);
        $year=$forward->year;
        $month=$forward->month;
        $day=$forward->day;
        $ymd=sprintf("%d-%02d-%02d",$year,$month,$day);
        $users=Date::with('user')->whereDate('updated_at',$ymd)->paginate(5);
        return view('date',compact('users','ymd'));
    }
}