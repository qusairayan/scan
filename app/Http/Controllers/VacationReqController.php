<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VacationReq;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



class VacationReqController extends Controller
{
    public function vacationReq(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'period' => 'required|integer',
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

            ], 400);
        }



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

                    if ($request->hasFile('image')) {

                        $image = $request->file('image');

                        // Generate a unique filename
                        $filename = $vacationReq->id . '.' . $image->getClientOriginalExtension();

                        // Store the image file
                        $path = $image->storeAs('leaves', $filename);

                        // $path will contain the path where the image file is stored

                       

                        
                    }

                  
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
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',

                ], 400);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Error, User does not  exist .',

            ], 400);
        }
    }
}
