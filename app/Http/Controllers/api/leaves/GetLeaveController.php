<?php

namespace App\Http\Controllers\api\leaves;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\leaveReq;
use Carbon\Carbon;

class GetLeaveController extends Controller
{
    public function getLeaves()
    {
        if (request()->has('user_id') && request()->has('last')) {

            $user_id = request()->input('user_id');
            $currentDateTime = Carbon::now();

            $lastLeave = LeaveReq::where('user_id', $user_id)->where('date', '>', $currentDateTime)
                ->where('time', '>', $currentDateTime->format('H:i:s'))->latest()->first();





            if ($lastLeave) {

                return response()->json([
                    'success' => true,
                    'Leave' => $lastLeave,

                ], 200);
            } else
                return response()->json([
                    'success' => false,
                    'Leave' => 'No data',

                ], 200);
        } else  if (request()->has('user_id')) {

            $user_id = request()->has('user_id');

            $allLeaves = LeaveReq::where('user_id', $user_id)->orderBy('id', 'desc')->get();

            $allLeavesArray = $allLeaves->toArray(); // Assign the result to a variable
            
            foreach ($allLeavesArray as &$leave) {
                $carbon = Carbon::createFromFormat('H:i:s', $leave['period']);
                
                if ($carbon !== false) {
                    $formattedTime = $carbon->format('H:i');
                    $leave['period'] = $formattedTime;
                }
            }
            

            return response()->json([
                'success' => true,
                'Leaves' => $allLeavesArray,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error, no data passed'

            ], 200);
        }
    }
}
