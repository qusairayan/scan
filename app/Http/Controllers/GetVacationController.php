<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacationReq;

class GetVacationController extends Controller
{
    public function getVacations(Request $request){


        if (request()->has('user_id')) {

            $user_id=request()->input('user_id');
            $Vacation = VacationReq::where('user_id',$user_id);




            if($Vacation){
                
            return response()->json([
                'success' => true,
                'vacation' => $Vacation,
    
            ], 200);
            }
            else
            return response()->json([
                'success' => false,
                'vacation' => 'No data',
    
            ], 200);
    


        }
        else {



        return response()->json([
            'success' => false,
            'message' => 'No User data Sent',
        ], 200);

        }
    }
}
