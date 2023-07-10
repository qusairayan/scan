<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class otpController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
    
    public function sendOtp(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'id' => 'required',
        ]);
        $email = $request->input('email');

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.',
                'email'=> $email
            ], 400);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        $id = $request->input('id');

        // Send OTP via email

        Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
            $message->to($email)
                ->subject('One-Time Password (OTP)');
        });



        User::where('id', $id)
       ->update([
        'email'=>$email,
           'otp' => $otp
        ]);

        // Store the OTP in the session
      

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.',
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }

        // Verify the OTP
        $otp = $request ->input('otp');

        // Retrieve the stored OTP from the session
        

        $id = $request->input('id');

        $user = User::find($id);
        $storedOtp =$user -> otp;

        if (!$storedOtp || $otp != $storedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
                            

            ], 400);
        }

        // OTP is valid, perform further actions or return success response
        // For example, update the user as verified, log in the user, etc.

        // Clear the OTP from the session
        $user -> otp = '';
        $user -> status = 1;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            
        ], 200);
        
    }
}
