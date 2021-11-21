<?php
error_reporting(-1);
ini_set('display_errors', 'On');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TypeServiceController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\FullCalendarEventMasterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => '/'], function () {

    Route::get("resetpassword/{code}", [UserController::class, "resetpassword"]);
    Route::any("resetnewpwd", [UserController::class, "resetnewpwd"]);

});


Route::get("/", [AuthenticationController::class, "showlogin"]);

Route::group(['prefix' => 'admin'], function () {
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::post("postlogin", [AuthenticationController::class, "postlogin"]);

    Route::group(['middleware' => ['AdminCheck']], function () {
        Route::get("dashboard", [AuthenticationController::class, 'showdashboard']);
        Route::get("logout", [AuthenticationController::class, 'logout']);

        Route::get("services", [ProductController::class, 'showservice']);
        Route::get("saveservices/{id}", [ProductController::class, "saveservices"]);
        Route::post("updateservice", [ProductController::class, "updateservice"]);
        Route::get("servicestable", [ProductController::class, "servicestable"]);
        Route::get("deleteservices/{id}", [ProductController::class, "deleteservices"]);

        Route::get("doctors", [DoctorController::class, "showdoctors"]);
        Route::get("doctorstable", [DoctorController::class, "doctorstable"]);
        Route::get("savedoctor/{id}", [DoctorController::class, "savedoctor"]);
        Route::post("updatedoctor", [DoctorController::class, "updatedoctor"]);
        Route::get("doctortiming/{id}", [DoctorController::class, "doctortiming"]);
        Route::get("findpossibletime", [DoctorController::class, "findpossibletime"]);
        Route::get("generateslot", [DoctorController::class, "generateslot"]);
        Route::post("savescheduledata", [DoctorController::class, "savescheduledata"]);
        Route::get("deletedoctor/{id}", [DoctorController::class, "deletedoctor"]);
        Route::get("approvedoctor/{id}/{status}", [DoctorController::class, "postapprovedoctor"]);

        Route::get("reviews", [DoctorController::class, 'showreviews']);
        Route::get("reviewtable", [DoctorController::class, "reviewtable"]);
        Route::get("deletereview/{id}", [DoctorController::class, "deletereview"]);

        Route::get("patients", [AuthenticationController::class, "showsuser"]);
        Route::get("userstable", [AuthenticationController::class, "userstable"]);
        Route::get("deleteuser/{id}", [AuthenticationController::class, "deleteuser"]);

        Route::get("editprofile", [AuthenticationController::class, "editprofile"]);
        Route::post("updateprofile", [AuthenticationController::class, "updateprofile"]);

        Route::get("changepassword", [AuthenticationController::class, "changepassword"]);
        Route::post("updatepassword", [AuthenticationController::class, "updatepassword"]);
        Route::get("check_password_same/{val}", [AuthenticationController::class, "checkcurrentpassword"]);
        Route::post("updateaccount", [AuthenticationController::class, "updateaccount"]);

        Route::get("appointment", [AppointmentController::class, "showappointment"]);
        Route::get("appointmenttable", [AppointmentController::class, "appointmenttable"]);
        Route::get("changeappstatus/{id}/{status_id}", [AppointmentController::class, "changeappstatus"]);

        Route::get("sendnotification", [NotificationController::class, "showsendnotification"]);
        Route::get("notificationkey", [NotificationController::class, "notificationkey"]);
        Route::post("updatenotificationkey", [NotificationController::class, "updatenotificationkey"]);
        Route::get("notificationtable", [NotificationController::class, "notificationtable"]);

        Route::get("savenotification", [NotificationController::class, "savenotification"]);
        Route::post("sendnotificationtouser", [NotificationController::class, "sendnotificationtouser"]);
        Route::get("notification/{id}", [AppointmentController::class, "notification"]);
        Route::get("latsrappointmenttable", [AppointmentController::class, "latsrappointmenttable"]);

        Route::get("complain", [AuthenticationController::class, "showcomplain"]);
        Route::get("compaintable", [AuthenticationController::class, "compaintable"]);

        Route::get("setting", [AuthenticationController::class, "showsetting"]);
        Route::post("updatesettingone", [AuthenticationController::class, "updatesettingone"]);
        Route::post("updatesettingtwo", [AuthenticationController::class, "updatesettingtwo"]);


        Route::get("plans", [PlanController::class, "showplans"]);
        Route::get("planstable", [PlanController::class, "planstable"]);
        Route::get("saveplan/{id}", [PlanController::class, "saveplan"]);
        Route::post("updateplan", [PlanController::class, "updateplan"]);
        Route::get("deleteplan/{id}", [PlanController::class, "deleteplan"]);

        Route::get("typeservices", [TypeServiceController::class, "showtypesservices"]);
        Route::get("typeservicetable", [TypeServiceController::class, "typeservicestable"]);
        Route::get("savetypeservice/{id}", [TypeServiceController::class, "savetypeservice"]);
        Route::post("updatetypeservice", [TypeServiceController::class, "updatetypeservice"]);
        Route::get("deletetypeservice/{id}", [TypeServiceController::class, "deletetypeservice"]);

        Route::get("clinics", [ClinicController::class, "showclinics"]);
        Route::get("clinicstable", [ClinicController::class, "clinicstable"]);
        Route::get("saveclinic/{id}", [ClinicController::class, "saveclinic"]);
        Route::post("updateclinic", [ClinicController::class, "updateclinic"]);
        Route::get("deleteclinic/{id}", [ClinicController::class, "deleteclinic"]);
        Route::get("viewlicense/{filename}", [ClinicController::class, "viewlicense"]);
    });

});
