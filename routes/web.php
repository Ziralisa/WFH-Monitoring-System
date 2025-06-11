<?php

use App\Http\Livewire\Admin\RoleSettings;
use App\Http\Livewire\Admin\UserSettings;
use App\Http\Livewire\Auth\Logout;
use App\Http\Livewire\DailyTask;
use App\Http\Livewire\User\Attendance;
use App\Http\Livewire\User\Profile as UserProfile1;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\UserRegister;
use App\Http\Livewire\Auth\RegisterCompany;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\NewUserHomepage;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use App\Http\Controllers\AttendanceController;
use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Livewire\SprintController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\googleController;




// Redirect to login page by default
Route::get('/', function () {
    return redirect('/login');
});

// Public Routes
Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/user-register', UserRegister::class)->name('userregister');
Route::get('/company-registration', RegisterCompany::class)->name('company-registration');
Route::get('/login', Login::class)->name('login');
Route::get('/auth/redirect/google/login', [GoogleController::class, 'redirectToGoogleLogin'])->name('google.login');
Route::get('/auth/redirect/google/register', [GoogleController::class, 'redirectToGoogleRegister'])->name('google.register');
Route::get('/auth/callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/logout', [Logout::class, 'logout'])->name('logout');
Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}', ResetPassword::class)
    ->name('reset-password')
    ->middleware('signed');
Route::middleware('role:user')->group(function () {
    Route::get('/new-user-homepage', action: NewUserHomepage::class)->name('new-user-homepage');
});


//ADMIN DASHBOARD
Route::group(['middleware' => ['can:view admin dashboard']], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});


//USER SETTING
Route::group(['middleware' => ['can:view user settings']], function () {
    Route::get('/admin/user', UserSettings::class)->name('admin.user-settings');
});

//ROLE SETTING
Route::group(['middleware' => ['can:view role settings']], function () {
    Route::get('/admin/role', RoleSettings::class)->name('admin.role');
});

//VIEW PROFILE
Route::group(['middleware' => ['can:view profile']], function () {
    Route::get('/user-profile', UserProfile1::class)->name('user-profile');
    Route::get('/user/{selectedUserId}', UserProfile1::class)->name('view-user-profile');

});

//TAKE ATTENDANCE ROUTES
Route::group(['middleware' => ['can:view take attendance']], function () {
    Route::get('/take-attendance', Attendance::class)->name('take-attendance');
    Route::POST('/update-location-session', [Attendance::class, 'updateLocationSession']);
    Route::POST('/save-location', [UserProfile1::class, 'saveLocation']);
    Route::get('/attendance-data', [Attendance::class, 'getAttendanceData']);

});

//ATTENDANCE STATUS (ADMIN)
Route::group(['middleware' => ['can:view attendance status']], function () {
    Route::get('/admin/attendance-status', [AttendanceController::class, 'attendanceStatus'])->name('attendanceStatus');
});

//ATTENDANCE REPORT (STAFF)
Route::group(['middleware' => ['can:view attendance report']], function () {
    Route::get('/attendance/report', [Attendance::class, 'showReport'])->name('report');
<<<<<<< HEAD
=======
    Route::get('/report/export', [Attendance::class, 'export'])->name('report.export');
>>>>>>> fbb6fa4 (company filtering implementation)
});

//ATTENDANCE REPORT (ADMIN)
Route::group(['middleware' => ['can:view attendance report staff']], function () {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
=======
    //Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
    Route::get('/attendance-report', [AttendanceController::class, 'index'])->name('attendance-report');
=======
    Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
>>>>>>> bf7d4fe (Revert "merge")
=======
    //Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
    Route::get('/attendance-report', [AttendanceController::class, 'index'])->name('attendance-report');
>>>>>>> 039ec79 (Reapply "merge")
=======
    Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
>>>>>>> 1a6b553 (Revert "merge")
=======
    //Route::get('/attendance-report', [Attendance::class, 'attendanceReport'])->name('attendance-report');
    Route::get('/attendance-report', [AttendanceController::class, 'index'])->name('attendance-report');
>>>>>>> 0e35d15 (Reapply "merge")
    Route::get('/report-pdf/pdf', [AttendanceController::class, 'downloadPdf'])->name('report-pdf.pdf');
});

//DEMO PAGES ROUTES
Route::group(['middleware' => ['can:view laravel examples']], function () {
>>>>>>> 270919a (merge)
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name(name: 'laravel-user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
});

// SPRINT AND TASK MANAGEMENT
Route::group(['middleware' => ['can:view backlog']], function () {
    Route::get('/tasks/sprint/{sprintId}', [SprintController::class, 'getTasksByProject'])
    ->name('tasks.sprint');
    
    Route::get('task-management/backlog', SprintController::class)->name('backlog.show');
    Route::post('task-management/backlog/add-sprint', [SprintController::class, 'storeSprint'])->name('create-sprint');
    Route::post('/tasks', [SprintController::class, 'storeTask'])->name('tasks.store');
    Route::post('/assign-task/{task}', [SprintController::class, 'assignTask'])->name('assign-task');
    Route::patch('/tasks/{task}/status', [SprintController::class, 'updateTaskStatus'])->name('tasks.updateStatus');
    Route::get('/tasks/{projectId}', [SprintController::class, 'getTasksByProject'])->name('tasks.byProject');
    Route::delete('/sprints/{sprint}', [SprintController::class, 'destroySprint'])->name('sprints.destroy');
    Route::put('/sprints/{sprint}', [SprintController::class, 'updateSprint'])->name('sprints.edit');
});

// DAILY TASK MANAGEMENT
Route::group(['middleware' => ['can:view daily tasks']], function () {
    Route::get('daily-management/task', DailyTask::class)->name('daily.show');
});

// PROJECT MANAGEMENT
Route::group(['middleware' => ['can:view project']], function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'storeProject'])->name('projects.store');
    Route::post('/projects/tasks', [ProjectController::class, 'storeTask'])->name('projects.tasks.store');
    Route::put('/tasks/{task}', [ProjectController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [ProjectController::class, 'destroyTask'])->name('tasks.destroy');
    Route::put('/projects/{project}', [ProjectController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroyProject'])->name('projects.destroy');
});
