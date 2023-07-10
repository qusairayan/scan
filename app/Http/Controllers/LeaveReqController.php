<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\leaveReq;


class leaveReqController extends Controller
{
    public function leaveReq(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'period' => 'required',
            'reason' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $user_id = $request->input('user_id');
        $period = $request->input('period');
        $reason = $request->input('reason');
        $date = $request->input('date');
        $time = $request->input('time');


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Values.',

            ], 400);}



            try {
            $user = User::findOrFail($user_id);



 


            $leavereq = new leavereq();
            $leavereq->user_id = $user_id;
            $leavereq->period = $period;
            $leavereq->reason = $reason;
            $leavereq->date = $date;
            $leavereq->time = $time;
            $success = $leavereq->save();

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave Request recorded Successfully .',

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Leavereq recorded Failed.',

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
