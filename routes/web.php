<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix'=>'dashboard','middleware'=>'auth'],function () {
    //dashboard
	Route::get('/', [Controller::class, 'create'])->name('dashboard');


	Route::group(['middleware'=>['role:examiner']],function(){
    Route::get('settings',[Controller::class,'settings'])->name('settings');
    Route::put('app-settings',[Controller::class,'update_app_settings'])->name('app.setting.update');

	Route::group(['prefix'=>'student','as'=>'user.'],function(){

		Route::get('lists',[UserController::class,'create'])->name('lists');

		Route::get('edit/{id}',[UserController::class,'show'])->name('show');

		Route::post('add',[UserController::class,'store'])->name('store');

		Route::put('update',[UserController::class,'edit'])->name('edit');

		Route::put('change-status',[UserController::class,'changeStatus'])->name('status');

		Route::delete('delete',[UserController::class,'destroy'])->name('delete');

	});

	Route::group(['prefix'=>'result','as'=>'result.'],function(){
		Route::get('add',[ResultController::class,'add_view'])->name('add.view');
		Route::post('add',[ResultController::class,'add'])->name('add');
		Route::put('edit',[ResultController::class,'edit'])->name('edit');
		Route::delete('delete',[ResultController::class,'destroy'])->name('delete');
		Route::put('change-status',[ResultController::class,'changeStatus'])->name('status');
		Route::put('general-status',[ResultController::class,'general_status'])->name('general.status');
		Route::get('upload',[ResultController::class,'upload'])->name('upload');
		Route::post('upload',[ResultController::class,'process_upload'])->name('upload.process');
		Route::get('manage',[ResultController::class,'manage'])->name('manage');
	});

	Route::group(['prefix'=>'course','as'=>'course.'],function(){
		Route::get('add',[CourseController::class,'create'])->name('add');
		Route::get('edit/{id}',[CourseController::class,'show'])->name('show');
		Route::post('add',[CourseController::class,'store'])->name('store');
		Route::put('update',[CourseController::class,'edit'])->name('edit');
		Route::delete('add',[CourseController::class,'destroy'])->name('delete');
	});

	Route::group(['prefix'=>'department','as'=>'department.'],function(){
		Route::get('add',[DepartmentController::class,'create'])->name('add');
		Route::get('edit/{id}',[DepartmentController::class,'show'])->name('show');
		Route::post('add',[DepartmentController::class,'store'])->name('store');
		Route::put('update',[DepartmentController::class,'edit'])->name('edit');
		Route::delete('add',[DepartmentController::class,'destroy'])->name('delete');
	});
	
	});
    
	Route::group(['middleware'=>['role:student']],function () {
		
    Route::group(['prefix'=>'register-course','as'=>'student-courses.'],function(){

		Route::get('/',[StudentCourseController::class,'create'])->name('add');

		Route::post('/',[StudentCourseController::class,'store'])->name('store');

		Route::delete('/',[StudentCourseController::class,'destroy'])->name('delete');

	});

	Route::group(['prefix'=>'result','as'=>'result.'],function(){
	Route::get('check',[StudentCourseController::class,'check_result'])->name('check');

	});

});

	//logout
	Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});

	// Auth
	Route::group(['middleware'=>'guest'],function () {
		Route::get('/',[AuthenticatedSessionController::class,'create']) ->name('login');
		Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
		Route::get('register',[RegisteredUserController::class,'create'])->name('register');
		Route::post('register',[RegisteredUserController::class,'store'])->name('register.store');
		Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'index'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');	
		});
	



	
	

