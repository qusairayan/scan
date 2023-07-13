<?php

namespace App\Http\Controllers\api\vacations;

use App\Http\Controllers\Controller;
use App\Models\leaveReq;
use Illuminate\Http\Request;
use App\Models\VacationReq;
use App\Models\User;
use Carbon\Carbon;




class GetVacationController extends Controller
{
    public function getVacations(Request $request){


        if (request()->has('user_id')) {
            $user_id=request()->input('user_id');

            $user = User::findOrFail($user_id);






            if ($user) {

            
            $givenDate = Carbon::parse($user->started_at);
            $currentDate = Carbon::now();
            
            $monthsDifference = $givenDate->diffInMonths($currentDate);


            $user_id=request()->input('user_id');
            $Vacation = VacationReq::where('user_id',$user_id)->orderBy('id','DESC')->get();
            $VacationSum = VacationReq::where('user_id',$user_id)->where('status',1)->sum('period');

            $leaveSum = intval(leaveReq::where('user_id',$user_id)->where('status',1)->count()/3);

      
                $VacationSum+= $leaveSum;
            

            
            
            $vacationBalance =$monthsDifference*1.2;
            $vacationBalance =number_format($vacationBalance , 2);
            $remeaning=number_format(($vacationBalance)-$VacationSum,2);

            if($Vacation){
                
            return response()->json([
                'success' => true,
                'vacationBalance'=>$vacationBalance,
                'vacationSum' => $VacationSum,
                'reamaning'=> $remeaning ,
                'vacation' => $Vacation,
    
            ], 200);
            }
            else
            return response()->json([
                'success' => false,
                'vacation' => 'No data',
    
            ], 200);
        }
        else
        return response()->json([
            'success' => false,
            'vacation' => 'User, Not found',

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
