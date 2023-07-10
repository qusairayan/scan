<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\otpController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveReqController;
use App\Http\Controllers\VacationReqController;
use App\Http\Controllers\GetVacationController;
use App\Http\Controllers\GetLeaveController;







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::middleware('csrf')->group(function () {
   
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/otp', [otpController::class, 'sendOtp']);
Route::post('/verifyOtp', [otpController::class, 'verifyOtp']);

Route::post('/attendence', [AttendanceController::class, 'attendence']);


Route::post('/leaveReq', [LeaveReqController::class, 'leaveReq']);
Route::post('/vacationReq', [VacationReqController::class, 'vacationReq']);


Route::post('/getVacation', [GetVacationController::class, 'getVacations']);
Route::post('/getLeave', [GetLeaveController::class, 'getLeaves']);

