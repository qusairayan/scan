<?php

namespace App\Http\Controllers;

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

            $allLeaves->toArray();

            json_encode($allLeaves);

            return response()->json([
                'success' => true,
                'Leaves' => $allLeaves,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error, no data passed'

            ], 200);
        }
    }
}
