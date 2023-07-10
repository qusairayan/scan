<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacationReq;

class GetVacationController extends Controller
{
    public function getVacations(Request $request){


        if (request()->has('id')) {

            $id=request()->input('id');
            $Vacation = VacationReq::find($id);




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
        else{


        $allVacations = VacationReq::all();

        $allVacations->toArray();

        json_encode($allVacations);

        return response()->json([
            'success' => true,
            'vacations' => $allVacations,
            'image'=>'Ashrf Taj Rask Wala',
        ], 200);

        }
    }
}
