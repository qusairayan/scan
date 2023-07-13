<?php

namespace App\Http\Controllers\api\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;
use GrahamCampbell\ResultType\Success;

class LoginController extends Controller
{

    public function login(Request $request)
    {






        // $credentials = $request->only('username', 'password');



        if ($request->has('password') && $request->has('username')) {
            $username = $request->input('username');
            $password = $request->input('password');
    
            $user = User::where('username', $username)->where('password', $password)->first();
                    
        if (!$user) {
            return response()->json([
                'message' => "The password or username doesn't match.",
                'status' => 201
            ]);



        } else {
            $id = $user->id;
            $name = $user->name;
            $status = $user->status;
            $company_id = $user->company_id;
            $company = Company::where('id', $company_id)->first();
            if ($company) {

                $company_name = $company->name;
                $company_lat = $company->latitude;
                $company_long = $company->longitude;
                $max_distance = $company->max_distance;
            }
            return response()->json([
                // 'token' => $token,
                'message' => 'Login successful', "status" => 200, "ID" => $id, "name" => $name,
                "UserStatus" => $status, "company_name" => $company_name,
                "latitude" => $company_lat, "longitude" => $company_long,
                'max_distance' => $max_distance
            ]);
        }

    }

    else{
        return response()->json([
            'success'=> false,
            'error'=>'Email or password is incorrect.'
        ]);
    }
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
