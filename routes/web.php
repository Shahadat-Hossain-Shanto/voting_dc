<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PermissionGroupController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;


require __DIR__ . '/auth.php';

//  New

Route::get('/voters', [VoteController::class, 'voters'])->name('voter.voters')->middleware ( [ 'auth' ] );
Route::get('/audit', [VoteController::class, 'audit'])->name('voter.audit')->middleware ( [ 'auth' ] );
Route::get('/secretaries', [VoteController::class, 'secretaries'])->name('voter.secretary')->middleware ( [ 'auth' ] );
Route::get('/presidents', [VoteController::class, 'presidents'])->name('voter.president')->middleware ( [ 'auth' ] );
Route::get('/voter/data', [VoteController::class, 'voterData'])->middleware ( [ 'auth' ] )->name('voter.data');
Route::get('/secretary/data', [VoteController::class, 'secretaryData'])->middleware ( [ 'auth' ] )->name('secretary.data');
Route::get('/president/data', [VoteController::class, 'presidentData'])->middleware ( [ 'auth' ] )->name('president.data');
Route::post('/voter/{id}/status', [VoteController::class, 'changeStatus'])->name('voter.changeStatus') ->middleware ( [ 'auth' ] );

Route::post('/voter/send-otp', [VoterController::class, 'sendOtp'])->name('voter.send.otp');
Route::post('/voter/verify-otp', [VoterController::class, 'verifyOtp'])->name('voter.verify.otp');
Route::post('/confirm-vote', [VoterController::class, 'confirm'])->name('confirm.vote');


Route::get('/voting', [VoterController::class, 'index'])->name('voting.index');
Route::get('/', [VoterController::class, 'select'])->name('voting.select');


Route::get ( '/clear', function ()
{
    $exitCode = Artisan::call ( 'optimize' );
    return $exitCode;
} );

Route::get ( 'phpinfo', function ()
{
    phpinfo ();
} )->middleware ( [ 'auth' ] );

Route::get ( '/home', [ DashboardController::class, 'logedIn' ] )->middleware ( [ 'auth' ] );


Route::middleware ( [ 'permission:user.create' ] )->group ( function ()
{
    Route::get ( '/create-user', [ AdminController::class, 'regUser' ] )->name ( 'user.create.view' );
    Route::post ( '/create-user', [ AdminController::class, 'storeUser' ] )->name ( 'user.create' );
} );
Route::get ( '/reset-password', [ AdminController::class, 'resetPassword' ] )->name ( 'reset.password' );
Route::put ( '/reset-password/{id}', [ AdminController::class, 'updatePassword' ] )->name ( 'reset.password.update' );

Route::get ( '/users-list', [ AdminController::class, 'userList' ] )->middleware ( [ 'permission:user.list.view' ] )->name ( 'user.list.view' );

Route::middleware ( [ 'permission:user.edit' ] )->group ( function ()
{
    Route::get ( '/user-edit/{id}', [ AdminController::class, 'userEdit' ] )->name ( 'user.edit.view' );
    Route::put ( '/user-edit/{id}', [ AdminController::class, 'userUpdate' ] )->name ( 'users.update' );
} );

Route::delete ( '/user-delete/{id}', [ AdminController::class, 'userDestroy' ] )->middleware ( [ 'permission:user.destroy' ] )->name ( 'users.destroy' );

Route::get ( '/users-status', [ AdminController::class, 'userStatus' ] )->middleware ( [ 'permission:user.status.view' ] )->name ( 'user.status.view' );

Route::middleware ( [ 'permission:activity.log.view' ] )->group ( function ()
{
    Route::get ( '/activity-log', [ ActivityLogController::class, 'activityLog_view' ] )->name ( 'activity.log.view' )->middleware ( [ 'auth' ] );
    Route::get ( '/activitylog-data', [ ActivityLogController::class, 'activitylog_data' ] )->middleware ( [ 'auth' ] )->name ( 'activity.log.view.data' );
} );

//roles
Route::middleware ( [ 'permission:roles.create' ] )->group ( function ()
{
    Route::get ( '/roles-create', [ RolesController::class, 'create' ] )->name ( 'roles.create.view' );
    Route::post ( '/roles-create', [ RolesController::class, 'store' ] )->name ( 'roles.create' );
} );

Route::get ( '/role-list', [ RolesController::class, 'index' ] )->middleware ( [ 'permission:roles.list.view' ] )->name ( 'roles.view' );

Route::middleware ( [ 'permission:roles.edit' ] )->group ( function ()
{
    Route::get ( '/role-edit/{id}', [ RolesController::class, 'edit' ] )->name ( 'roles.edit' );
    Route::put ( '/role-edit/{id}', [ RolesController::class, 'update' ] )->name ( 'roles.edit.update' );
} );

Route::delete ( '/role-delete/{id}', [ RolesController::class, 'destroy' ] )->middleware ( [ 'permission:roles.destroy' ] )->name ( 'roles.destroy' );

//permissions
Route::middleware ( [ 'permission:permission.create' ] )->group ( function ()
{
    Route::get ( '/permission-create', [ PermissionController::class, 'create' ] )->name ( 'permission.create.view' );
    Route::post ( '/permission-create', [ PermissionController::class, 'store' ] )->name ( 'permission.create' );
} );

Route::middleware ( [ 'permission:permission.list.view' ] )->group ( function ()
{
    Route::get ( '/permission-list', [ PermissionController::class, 'index' ] )->name ( 'permission.list.view' );
    Route::get ( '/permission-list-data', [ PermissionController::class, 'listData' ] )->name ( 'permission.list.data' );
} );

Route::middleware ( [ 'permission:permission.edit' ] )->group ( function ()
{
    Route::get ( '/permission-edit/{id}', [ PermissionController::class, 'edit' ] )->name ( 'permission.edit' );
    Route::put ( '/permission-edit/{id}', [ PermissionController::class, 'update' ] )->name ( 'permission.update' );
} );

Route::delete ( '/permission-delete/{id}', [ PermissionController::class, 'destroy' ] )->middleware ( [ 'permission:permission.destroy' ] )->name ( 'permission.destroy' );

//Permission group
Route::middleware ( [ 'permission:permission.group.create' ] )->group ( function ()
{
    Route::get ( '/permission-group-add', [ PermissionGroupController::class, 'create' ] )->name ( 'permission.group.create.view' );
    Route::post ( '/permission-group-add', [ PermissionGroupController::class, 'store' ] )->name ( 'permission.group.store' );
} );

Route::middleware ( [ 'permission:permission.group.list.view' ] )->group ( function ()
{
    Route::get ( '/permission-group-list', [ PermissionGroupController::class, 'list' ] )->name ( 'permission.group.list.view' );
    Route::get ( '/permission-group-list-data', [ PermissionGroupController::class, 'listData' ] )->name ( 'permission.group.list.data' );
} );

Route::middleware ( [ 'permission:permission.group.edit' ] )->group ( function ()
{
    Route::get ( '/permission-group-edit/{id}', [ PermissionGroupController::class, 'edit' ] )->name ( 'permission.group.edit.view' );
    Route::put ( '/permission-group-edit/{id}', [ PermissionGroupController::class, 'update' ] )->name ( 'permission.group.update' );
} );

Route::delete ( '/permission-group-delete/{id}', [ PermissionGroupController::class, 'destroy' ] )->middleware ( [ 'permission:permission.group.destroy' ] )->name ( 'permission.group.destroy' );


