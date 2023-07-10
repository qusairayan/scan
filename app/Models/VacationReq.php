<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationReq extends Model
{
    protected $table = 'vacations';
    protected $fillable = ['id','user_id','type','period', 'date', 'asset','status'];
}
