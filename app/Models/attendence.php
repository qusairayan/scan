<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendence extends Model
{
protected $table='attendence';
protected $fillable=['id','date','time','user_id','type'];




}
