<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    protected $table='breaktimes';

    protected $fillable=['user_id','break_in','break_out'];

    public function users(){
        return $this->belongsTo('App\Models\User');
    }

    public function dates(){
        return $this->belongsToMany('App\Models\Date');
    }
}
