<?php

use App\Http\Controllers\LocationController;
use App\Http\Livewire\Auth\Logout;
use App\Http\Livewire\Attendance\AttendanceComponent;
use App\Http\Livewire\User\Attendance;
use App\Http\Livewire\User\Profile as UserProfile1;
use App\Http\Livewire\Admin\ApproveUsers;
use App\Http\Livewire\Dashboard1;
use App\Http\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\NewUserHomepage;
use App\Http\Livewire\Admin\StaffList;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use App\Http\Controllers\AttendanceController;
use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Livewire\Attendance\Index as AttendanceIndex;

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

// Redirect to login page by default
Route::get('/', function () {
    return redirect('/login');
});

// Public Routes
Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', [Logout::class, 'logout'])->name('logout');
Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}', ResetPassword::class)
    ->name('reset-password')
    ->middleware('signed');

Route::middleware('role:user')->group(function () {
    Route::get('/new-user-homepage', action: NewUserHomepage::class)->name('new-user-homepage');
});

//ADMIN ROUTES
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/staff-list', [StaffController::class, 'index'])->name('admin.staff-list');
    Route::get('/admin/approve-users', ApproveUsers::class)->name('approve-users');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::put('admin/staff/{id}', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::post('/admin/staff/remove-role/{id}', [StaffController::class, 'removeRole'])->name('admin.staff.remove-role');
    Route::delete('/admin/staff/{id}', [StaffController::class, 'destroy'])->name('admin.staff.delete');

});

// Attendance Routes (Staff Only)
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/attendance/component', AttendanceComponent::class)->name('attendance.component');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
    Route::get('/calculate-points', [AttendanceController::class, 'calculateWorkHoursPoints'])
        ->name('attendance.calculate-points');
    Route::get('/attendance/report', [Attendance::class, 'showReport'])->name('attendance.report');
    Route::get('/attendance/report', [Attendance::class, 'showReport'])->name('report');
    Route::get('/dashboard1', Dashboard1::class)->name('dashboard1');
    Route::get('/user-profile', UserProfile1::class)->name('user-profile');
    Route::get('/take-attendance', Attendance::class)->name('take-attendance');
    Route::POST('/update-location-session', [LocationController::class, 'saveLocation']);
    Route::POST('/save-location', [UserProfile1::class, 'saveLocation']);

});

//DEMO PAGES ROUTES
Route::get('/billing', Billing::class)->name('billing');
Route::get('/profile', Profile::class)->name('profile');
Route::get('/tables', Tables::class)->name('tables');
Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
Route::get('/rtl', Rtl::class)->name('rtl');
Route::get('/laravel-user-profile', UserProfile::class)->name(name: 'laravel-user-profile');
Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
Route::get('/counter', Counter::class);


