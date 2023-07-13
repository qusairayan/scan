<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\login\LoginController;
use App\Http\Controllers\api\attendence\AttendanceController;

use App\Http\Controllers\api\leaves\LeaveReqController;
use App\Http\Controllers\api\leaves\GetLeaveController;

use App\Http\Controllers\api\vacations\VacationReqController;
use App\Http\Controllers\api\vacations\GetVacationController;

use App\Http\Controllers\api\profile\ProfileController;
use App\Http\Controllers\api\profile\showProfileImageController;







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::middleware('csrf')->group(function () {
   
});

Route::middleware(['api'])->group(function () {
Route::post('/profile', [ProfileController::class, 'profile']);
    
});



Route::post('/login', [LoginController::class, 'login']);
Route::post('/ActivateOtp', [LoginController::class, 'sendOtp']);
Route::post('/ActivateVerifyOtp', [LoginController::class, 'verifyOtp']);

Route::post('/attendence', [AttendanceController::class, 'attendence']);


Route::post('/leaveReq', [LeaveReqController::class, 'leaveReq']);
Route::post('/vacationReq', [VacationReqController::class, 'vacationReq']);


Route::post('/getVacation', [GetVacationController::class, 'getVacations']);
Route::post('/getLeave', [GetLeaveController::class, 'getLeaves']);

Route::post('/getProfile', [ProfileController::class, 'getProfile']);
Route::post('/profileOTP', [ProfileController::class, 'profileOTP']);
Route::post('/profilePassword', [ProfileController::class, 'profilePassword']);
Route::post('/updateProfile', [ProfileController::class, 'updateProfile']);

Route::post('/profileIMG/{filename}', [showProfileImageController::class, 'showProfileImage']);








