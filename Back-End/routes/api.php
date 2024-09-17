<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//
Route::get('/', function () {
    return view('home');
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);


//RoleGroup + RoleGroupCompany && Permissions

Route::resource('permission', 'App\Http\Controllers\PermissionController');
Route::resource('rolegroup', 'App\Http\Controllers\RoleGroupController');
Route::resource('rolegroupcompany', 'App\Http\Controllers\RoleGroupCompanyController');


//Resources Admin
Route::resource('companyadmin', 'App\Http\Controllers\CompanyAdminController');
Route::resource('invitationadmin', 'App\Http\Controllers\InvitationAdminController');
Route::resource('jobadmin', 'App\Http\Controllers\JobAdminController');
Route::resource('projectadmin', 'App\Http\Controllers\ProjectAdminController');
Route::resource('reminderadmin', 'App\Http\Controllers\ReminderAdminController');
Route::resource('sectionadmin', 'App\Http\Controllers\SectionAdminController');
Route::resource('taskadmin', 'App\Http\Controllers\TaskAdminController');
Route::resource('workspaceadmin', 'App\Http\Controllers\WorkspaceAdminController');
Route::resource('departmentadmin', 'App\Http\Controllers\DepartmentAdminController');
Route::resource('unitadmin', 'App\Http\Controllers\UnitAdminController');
Route::resource('processadmin', 'App\Http\Controllers\ProcessAdminController');
Route::resource('processtype', 'App\Http\Controllers\ProcessTypeController');
Route::resource('ticketadmin', 'App\Http\Controllers\TicketAdminController');

//Resources
Route::resource('company', 'App\Http\Controllers\CompanyController');
Route::resource('invitation', 'App\Http\Controllers\InvitationController');
Route::resource('job', 'App\Http\Controllers\JobController');
Route::resource('project', 'App\Http\Controllers\ProjectController');
Route::resource('reminder', 'App\Http\Controllers\ReminderController');
Route::resource('section', 'App\Http\Controllers\SectionController');
Route::resource('task', 'App\Http\Controllers\TaskController');
Route::resource('workspace', 'App\Http\Controllers\WorkspaceController');
Route::resource('department', 'App\Http\Controllers\DepartmentController');
Route::resource('unit', 'App\Http\Controllers\UnitController');
Route::resource('process', 'App\Http\Controllers\ProcessController');
Route::resource('notification', 'App\Http\Controllers\NotificationController');
Route::resource('ticket', 'App\Http\Controllers\TicketController');

Route::resource('user', 'App\Http\Controllers\UserController');

//Assign Function
Route::post('/assign_project',[App\Http\Controllers\ProjectController::class,'assign_project']);
Route::post('/assign_task_to_user',[App\Http\Controllers\TaskController::class,'assign_task_to_user']);
Route::post('/assign_CEO_to_company',[App\Http\Controllers\CompanyController::class,'assign_CEO_to_company']);
Route::post('/assign_director_to_department',[App\Http\Controllers\DepartmentController::class,'assign_director_to_department']);
Route::post('/assign_HOU_to_unit',[App\Http\Controllers\UnitController::class,'assign_HOU_to_unit']);
Route::post('/assign_HOS_to_section',[App\Http\Controllers\SectionController::class,'assign_HOS_to_section']);
Route::post('/assign_manager_to_workspace',[App\Http\Controllers\WorkspaceController::class,'assign_manager_to_workspace']);
Route::post('/assign_PM_to_project',[App\Http\Controllers\ProjectController::class,'assign_PM_to_project']);

//RoleGroupCompanyPermission RoleGroupPermission
//UserNotification UserProject UserSection UserWorkspace UserCompany UserTask
//UserRoleGroup UserRoleGroupCompany

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Tasks
Route::post('/approvetask',[App\Http\Controllers\TaskController::class,'approvetask']);
Route::post('/confirmtask',[App\Http\Controllers\TaskController::class,'confirmtask']);
Route::post('/rejecttask',[App\Http\Controllers\TaskController::class,'rejecttask']);
Route::post('/submittoreview',[App\Http\Controllers\TaskController::class,'SubmitToReview']);
Route::post('/submittask',[App\Http\Controllers\TaskController::class,'SubmitReviewedTask']);
Route::post('/getextraupperapprove',[App\Http\Controllers\TaskController::class,'GetExtraUpperApprove']);

//Tickets
Route::post('/approveticket',[App\Http\Controllers\TicketController::class,'approveticket']);
Route::post('/rejectticket',[App\Http\Controllers\TicketController::class,'rejectticket']);

//Timer
Route::put('/tasks/{timer_id}/{duration}/timers/stop',[App\Http\Controllers\TimerController::class,'TaskTimerStopRunning']);
Route::post('/tasks/{task_id}/timers',[App\Http\Controllers\TimerController::class,'TaskTimerStore']);
Route::get('/task/timers/active',[App\Http\Controllers\TimerController::class,'TaskTimerRunning']);

Route::put('/users/{timer_id}/{duration}/timers/stop',[App\Http\Controllers\TimerController::class,'UserTimerStopRunning']);
Route::post('/users/{name}/timers',[App\Http\Controllers\TimerController::class,'UserTimerStore']);
Route::get('/user/timers/active',[App\Http\Controllers\TimerController::class,'UserTimerRunning']);

//Company
Route::get('/searchcompany',[App\Http\Controllers\CompanyController::class,'searchcompany']);
Route::post('/joincompany',[App\Http\Controllers\CompanyController::class,'joincompany']);
Route::get('/getcompanytype',[App\Http\Controllers\CompanyController::class,'getcompanytype']);

//CompanyWorkflow
Route::post('/createcompanyworkflow',[App\Http\Controllers\CompanyWorkflowController::class,'CreateCompanyWorkflow']);


//workspace fetch data
Route::get('/fetchdata',[App\Http\Controllers\WorkspaceController::class,'FetchData']);

Route::get('/projectindex/{id}',[App\Http\Controllers\ProjectController::class,'ProjectIndex']);
Route::get('/taskindex/{id}',[App\Http\Controllers\TaskController::class,'TaskIndex']);
Route::get('/task/create/{id}',[App\Http\Controllers\TaskController::class,'create']);


//Filter
Route::get('/taskfilter',[App\Http\Controllers\TaskController::class,'TaskFilter']);
Route::post('/pulltask/{id}',[App\Http\Controllers\TaskController::class,'PullTask']);