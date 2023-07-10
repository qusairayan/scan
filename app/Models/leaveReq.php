<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leaveReq extends Model
{
    protected $table = 'leaves';
    protected $fillable = ['id','user_id','reason','period', 'date', 'time','status'];
}
