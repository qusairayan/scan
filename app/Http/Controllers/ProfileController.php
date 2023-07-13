<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\FlareClient\Http\Exceptions\InvalidData;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function updateProfile(Request $request)
    {
        if (request()->has('id')) {
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

            $name = $request->input('name');
            $email = $request->input('email');

            if ($email != $user->email) {
                $otp = rand(100000, 999999);

                Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
                    $message->to($email)
                        ->subject('One-Time Password (OTP)');
                });
                if (request()->has('image')) {


                    $prevImg = $user->image;
                    if ($prevImg != '') {
                        Storage::delete('public/profile/' . $prevImg);
                    }



                    $image = $request->file('image');

                    $filename = $user->id . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('public/profile', $filename);
                    if ($path) {
                        $user->image = $id . '.' . $image->getClientOriginalExtension();
                    }
                }
                $user->name = $name;
                $user->save();

                Session::put('verify_email_' . strval($id), $email);
                $user->otp = $otp;
                $user->save();
                return response()->json([
                    'success' => true,
                    'otpSent' => true,
                    'message' => 'OTP sent successfully to verify Email, Profile updated successfully ',
                ], 200);
            } else {


                if (request()->has('image')) {



                    $prevImg = $user->image;
                    if ($prevImg != '') {
                        Storage::delete('public/profile/' . $prevImg);
                    }


                    $image = $request->file('image');

                    $filename = $user->id . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('public/profile', $filename);
                    $user->image = $id . '.' . $image->getClientOriginalExtension();
                    $user->name = $name;
                    $user->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Profile updated successfully ',
                    ], 200);
                }


               

                return response()->json([
                    'success' => $name,
                    'message' => 'Profile updated successfully.',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error: No user provided'
            ], 201);
        }
    }


    public function profileOTP(Request $request)
    {


        if (request()->has('id') && request()->has('otp')) {
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
                    'success' => false,
                    'message' => 'Invalid OTP.',
                ], 201);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error: No user provided'
            ], 201);
        }
    }

    public function profilePassword(Request $request)
    {

        if (request()->has('id') && request()->has('password') && request()->has('newPassword')) {

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'password' => 'required|string',
                'newPassword' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'messages' => 'Invalid data'
                ]);
            }
            $id = request()->input('id');

            $user = User::where('id', $id)->first();

            $password = request()->input('password');
            $newPassword = request()->input('newPassword');
            if ($user->password == $password) {
                $user->password = $newPassword;
                $user->save();
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error: No data provided'
            ], 201);
        }
    }
    public function getProfile(Request $request)
    {
        if (request()->has('id')) {
            $id = request()->input('id');

            $user = User::where('id', $id)->first();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'data' => $user,
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
