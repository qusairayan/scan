<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;


class AuthController extends Controller
{

    public function login(Request $request)
    {






        // $credentials = $request->only('username', 'password');



        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->where('password', $password)->first();

        if (!$user) {
            return response()->json([
                'message' => 'The password or username provided password is incorrect.',
                'status' => 201
            ]);



            return response()->json(['message' => 'ghi', "status" => 150], 401);
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
}
