<?php

namespace App\Http\Controllers\api\attendence;

use App\Http\Controllers\Controller;
use App\Models\attendence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;



class AttendanceController extends Controller
{



    public function attendence(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required|in:0,1,2',
        ]);

        $id = $request->input('id');
        $type = $request->input('type');


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Values.',

            ], 400);}


            try {
                $user = User::findOrFail($id);

                $currentDateTime = Carbon::now();


                $currentTime = $currentDateTime->format('H:i');
                $currentDate = $currentDateTime->format('Y-m-d');


                $attendence = new attendence();
                $attendence->user_id = $id;
                $attendence->type = $type;
                $attendence->date = $currentDate;
                $attendence->time = $currentTime;
                $success = $attendence->save();

                if ($success) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Attendence recorded Successfully .',

                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Attendence recorded Failed.',

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
