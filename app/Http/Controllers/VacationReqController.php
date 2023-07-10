<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VacationReq;


class VacationReqController extends Controller
{
 public function vacationReq (Request $request){

    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'period' => 'required',
        'type' => 'required',
        'date' => 'required',
        
    ]);

    $user_id = $request->input('user_id');
    $period = $request->input('period');
    $type = $request->input('type');
    $date = $request->input('date');


    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid Values.',

        ], 400);}



        try {
        $user = User::findOrFail($user_id);






if ($user) {


        $vacationReq = new VacationReq();
        $vacationReq->user_id = $user_id;
        $vacationReq->period = $period;
        $vacationReq->type = $type;
        $vacationReq->date = $date;
        $success = $vacationReq->save();


        

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Vacation Request recorded Successfully .',

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Vacation Request recorded Failed.',

            ], 400);
        }


}
else{
return response()->json([
    'success' => false,
    'message' => 'User not found.',

], 400);
}


    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'User does not  exist .',

        ], 400);
    }


}

}
