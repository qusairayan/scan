<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function profile(Request $request)
    {
        if (request()->has('id') && request()->has('update')) {
            $id = request()->input('id');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong Data'
                ], 201);
            }

            $user = User::where('id', $id)->first();

            try {
                $name = $request->input('name');
                $email = $request->input('email');

                if ($email != $user->email) {
                    $otp = rand(100000, 999999);
                    
                    Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
                        $message->to($email)
                            ->subject('One-Time Password (OTP)');
                    });

                    $user->name = $name;
                    $user->save();

                    // Move the Session::put() statement here
                    Session::put('verify_email_' . strval($id), $email);
                    $user ->otp=$otp;
                    $user ->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'OTP sent successfully, Name updated successfully ',
                    ], 200);
                } else {
                    $user->name = $name;
                    $user->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Profile updated successfully.',
                    ], 200);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else if (request()->has('id') && request()->has('otp')) {
            $id = request()->input('id');
            $otp = request()->input('otp');
            $user = User::where('id', $id)->first();

            if ($user->otp == $otp) {
                $user->email = Session::get('verify_email_' . strval($id));
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Email updated successfully.',
                ], 200);
            } else {
                return response()->json([
                    'success' =>false,
                    'message' => 'Invalid OTP.',
                ], 201);
            }
        } else if (request()->has('id')) {
            $id = request()->input('id');

            $user = User::where('id', $id)->first();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 201);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error: No user provided'
            ], 201);
        }
    }
}
