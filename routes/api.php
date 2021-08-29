<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth::guard('sanctum')->user();

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout',[LogoutController::class,'logout']);

    ///employee routes
    Route::prefix('employees')->group(function () {
        Route::post('/store',[EmployeeController::class,'store']);
        Route::post('/update/{employee}',[EmployeeController::class,'update']);
        Route::get('/list',[EmployeeController::class,'index']);
        Route::get('/{id}',[EmployeeController::class,'show']);
        Route::get('/education/{employee_id}',[EmployeeController::class,'showEmployeeEducation']);
        Route::get('/experience/{employee_id}',[EmployeeController::class,'showEmployeeExperice']);
        Route::get('/promotion/{employee_id}',[EmployeeController::class,'showEmployeePromotion']);
        Route::get('/training/{employee_id}',[EmployeeController::class,'showEmployeeTraining']);
    });


    //leaves list
    Route::prefix('leaves')->group(function () {
        Route::get('/list',[LeaveController::class,'index']);
        Route::get('/show/{leave}',[LeaveController::class,'show']);
        Route::post('/add',[LeaveController::class,'store']);
        Route::post('/update/{leave}',[LeaveController::class,'update']);
        Route::delete('/delete/{leave}',[LeaveController::class,'destroy']);
    });
    // end of leave list route


    //Holiday list
    Route::prefix('holidays')->group(function () {
        Route::get('/list',[LeaveController::class,'index']);
        Route::get('/show/{leave}',[LeaveController::class,'show']);
        Route::post('/add',[LeaveController::class,'store']);
        Route::post('/update/{leave}',[LeaveController::class,'update']);
        Route::delete('/delete/{leave}',[LeaveController::class,'destroy']);
    });
    // end of leave list route



    // leave type list
    Route::get('/leave_type/list',[LeaveTypeController::class,'index']);
    Route::prefix('leaveTypes')->group(function () {
        Route::get('/show/{leaveType}',[LeaveTypeController::class,'show']);
        Route::post('/add',[LeaveTypeController::class,'store']);
        Route::post('/update/{leaveType}',[LeaveTypeController::class,'update']);
        Route::delete('/delete/{leaveType}',[LeaveTypeController::class,'destroy']);
    }); //end leavetype routes



    //departments routes
    Route::prefix('department')->group(function () {
        Route::get('/list',[DepartmentController::class,'index']);
        Route::get('/show/{id}',[DepartmentController::class,'show']);
        Route::post('/store',[DepartmentController::class,'store']);
        Route::post('/update/{id}',[DepartmentController::class,'update']);
        Route::delete('/destroy/{id}',[DepartmentController::class,'destroy']);
    }); //end department routes

});



Route::post('/login',[LoginController::class,'login']);
