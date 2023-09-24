<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Date;
use App\Models\BreakTime;

class DateController extends Controller
{
    public function index(){
        $users=Date::with('user')->paginate(5);
        return view('date',compact('users'));
    }
}
