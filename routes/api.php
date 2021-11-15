<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any("searchdoctor",[ApiController::class,"showsearchdoctor"]);
Route::any("nearbydoctor",[ApiController::class,"nearbydoctor"]);
Route::any("register",[ApiController::class,"postregisterpatient"]);
Route::any("savetoken",[ApiController::class,"storetoken"]);
Route::any("login",[ApiController::class,"showlogin"]);
Route::any("doctorregister",[ApiController::class,"doctorregister"]);
Route::any("doctorlogin",[ApiController::class,"doctorlogin"]);
Route::any("getspeciality",[ApiController::class,"getspeciality"]);
Route::any("bookappointment",[ApiController::class,"bookappointment"]);
Route::any("viewdoctor",[ApiController::class,"viewdoctor"]);
Route::any("addreview",[ApiController::class,"addreview"]);
Route::any("getslot",[ApiController::class,"getslotdata"]);
Route::any("getlistofdoctorbyspecialty",[ApiController::class,"getlistofdoctorbyspecialty"]);
Route::any("usersuappointment",[ApiController::class,"usersupcomingappointment"]);
Route::any("userspastappointment",[ApiController::class,"userspastappointment"]);
Route::any("doctoruappointment",[ApiController::class,"doctoruappointment"]);
Route::any("doctorpastappointment",[ApiController::class,"doctorpastappointment"]);
Route::any("reviewlistbydoctor",[ApiController::class,"reviewlistbydoctor"]);
Route::any("doctordetail",[ApiController::class,"doctordetail"]);
Route::any("appointmentdetail",[ApiController::class,"appointmentdetail"]);
Route::any("doctoreditprofile",[ApiController::class,"doctoreditprofile"]);
Route::any("usereditprofile",[ApiController::class,"usereditprofile"]);
Route::any("getdoctorschedule",[ApiController::class,"getdoctorschedule"]);
Route::any("Reportspam",[ApiController::class,"saveReportspam"]);
Route::any("appointmentstatuschange",[ApiController::class,"appointmentstatuschange"]);
Route::any("forgotpassword",[ApiController::class,"forgotpassword"]);

