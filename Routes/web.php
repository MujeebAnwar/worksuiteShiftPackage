<?php

use App\GlobalCurrency;
use App\GlobalSetting;
use App\LanguageSetting;
use App\PushNotificationSetting;
use Illuminate\Support\Facades\Route;
use Modules\Shifts\Http\Controllers\AssignShiftController;
use Modules\Shifts\Http\Controllers\Employees\AssignedShifts;
use Modules\Shifts\Http\Controllers\ShiftController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web','auth', 'role:admin']], function(){


    Route::get('employees/{dep_id}',[AssignShiftController::class,'getEmployees'])->name('getEmployees');
    Route::get('shifts/get',[ShiftController::class,'data'])->name('getShifts');
    Route::post('assign-shift/shortcut',[AssignShiftController::class,'shortcutShifts'])->name('shortcutShiftAssign');
    Route::post('match-employee',[AssignShiftController::class,'matachedEmployeeShift'])->name('matachedEmployeeShift');
    Route::get('project-task/{project_id}',[ShiftController::class,'getProjectTask'])->name('getProjectTask');
    Route::resource('shifts',ShiftController::class);
    Route::resource('assign-shift',AssignShiftController::class);
    Route::post('assign-shift/search',[AssignShiftController::class,'search'])->name('search');
    Route::DELETE('assign-shift/delete/employee/{id}',[AssignShiftController::class,'deleteForSingleEmployee'])->name('deleteForSingleEmployee');
    Route::DELETE('assign-shift/delete/all-employees/{id}',[AssignShiftController::class,'deleteForAllEmployees'])->name('deleteForAllEmployees');

});


Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['web','auth','role:employee']], function () {

   Route::get('assigned-shift', [AssignedShifts::class,'index'])->name('employeeShiftAssigned');
});
