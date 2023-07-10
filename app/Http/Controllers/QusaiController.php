<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class QusaiController extends Controller
{
    
public function CreatUser (){
    
    

    $user = new User;
    $user->name = ('test');
    $user->email = ('test@test.com');
    $user->password = Hash::make(('test1234'));
    $user->username = ('test');
    $user->company_id = 0;
    $user->status = 0;
    $user->role = 1;
    $user->token = Str::random(60); // Generate a random token
    
    // Save the user to the database
    $user->save();
    
    
    }
}




