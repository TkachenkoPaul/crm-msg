<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MessageTypeController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReportController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->group(function () {
    Route::get('/', [MessagesController::class, 'index'])->name('messages.index')->middleware('can:view messages');
    Route::get('/messages/list', [MessagesController::class, 'datatables'])->name('messages.list')->middleware('can:view messages');
    Route::get('/message/{id}/', [MessagesController::class, 'show'])->name('messages.show')->middleware('can:view messages');
    Route::get('/message/export/pdf', [MessagesController::class, 'exportPdf'])->name('messages.show.all.pdf')->middleware('can:view reports pdf');
    Route::get('/message/export/excel', [MessagesController::class, 'exportExcel'])->name('messages.show.all.excel')->middleware('can:view reports excel');
    Route::post('/message/import/excel', [MessagesController::class, 'importExcel'])->name('messages.import.excel')->middleware('can:create messages');
    Route::get('/message/{id}/pdf', [MessagesController::class, 'showPdf'])->name('messages.show.pdf')->middleware('can:create messages');
    Route::post('/message/{id}/', [MessagesController::class, 'update'])->name('messages.update')->middleware('can:update messages');
    Route::get('/messages/update/', [MessagesController::class, 'updateMessages'])->name('messages.update.group')->middleware('can:view roles');
    Route::get('/message/delete/{id}/', [MessagesController::class, 'destroy'])->name('messages.destroy')->middleware('can:delete messages');
    Route::get('/messages/add', [MessagesController::class, 'create'])->name('messages.create')->middleware('can:create messages');
    Route::get('/messages/regions/add', [MessagesController::class, 'createRegions'])->name('messages.create.regions')->middleware('can:create messages');
    Route::post('/messages/add', [MessagesController::class, 'store'])->name('messages.store')->middleware('can:create messages');

    Route::get('/appeals', [AppealController::class, 'index'])->name('appeals.index')->middleware('can:view messages');
    Route::get('/appeals/list', [AppealController::class, 'datatables'])->name('appeals.list')->middleware('can:view messages');
    Route::get('/appeal/delete/{id}/', [AppealController::class, 'destroy'])->name('appeals.destroy')->middleware('can:delete messages');
    Route::get('/appeal/accept/{id}/', [AppealController::class, 'accept'])->name('appeals.accept')->middleware('can:view messages');
    Route::prefix('monitor/jobs')->group(function () {
        Route::queueMonitor();
    })->middleware('can:view reports');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('can: view reports');
    Route::get('/reports/list', [ReportController::class, 'datatables'])->name('reports.list')->middleware('can: view reports');
    Route::get('/reports/delete/{id}', [ReportController::class, 'destroy'])->name('reports.destroy')->middleware('can: delete reports');
    Route::get('/reports/download/{id}', [ReportController::class, 'download'])->name('reports.download')->middleware('can: view reports');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store')->middleware('can: create reports');

//    Route::get('/messages/operations', [OperationController::class, 'index'])->name('operations.index')->middleware('can:view roles');
//    Route::get('/messages/operations/list', [OperationController::class, 'datatables'])->name('operations.list')->middleware('can:view roles');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('can:view roles');
    Route::get('/roles/list', [RoleController::class, 'datatables'])->name('roles.list')->middleware('can:view roles');
    Route::get('/roles/{id}/', [RoleController::class, 'show'])->name('roles.show')->middleware('can:view roles');
    Route::post('/roles/{id}/', [RoleController::class, 'update'])->name('roles.update')->middleware('can:update roles');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('can:delete roles');
    Route::get('/role/add/', [RoleController::class, 'create'])->name('roles.create')->middleware('can:create roles');
    Route::post('/role/add/', [RoleController::class, 'store'])->name('roles.store')->middleware('can:create roles');

    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:view users');
    Route::get('/users/list', [UserController::class, 'datatables'])->name('users.list')->middleware('can:view users');
    Route::get('/users/{id}/show', [UserController::class, 'show'])->name('users.show')->middleware('can:view users');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update')->middleware('can:update users');
    Route::get('/users/{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:delete users');
    Route::get('/users/add', [UserController::class, 'create'])->name('users.create')->middleware('can:create users');
    Route::post('/users/add', [UserController::class, 'store'])->name('users.store')->middleware('can:create users');

    Route::post('/message/{id}/reply/add', [ReplyController::class, 'store'])->name('reply.store')->middleware('can:create replies');
    Route::get('/message/{id}/reply/destroy', [ReplyController::class, 'destroy'])->name('reply.destroy')->middleware('can:destroy replies');

    Route::get('/users/report/', [UserReportController::class, 'index'])->name('user-report.index')->middleware('can:view statistic');
    Route::get('/users/report/list', [UserReportController::class, 'datatables'])->name('user-report.list')->middleware('can:view statistic');

    Route::get('/types', [MessageTypeController::class, 'index'])->name('types.index')->middleware('can:view types');
    Route::get('/types/list', [MessageTypeController::class, 'datatables'])->name('types.list')->middleware('can:view types');

    Route::get('/status', [StatusTypeController::class, 'index'])->name('status.index')->middleware('can:view statuses');
    Route::get('/status/list', [StatusTypeController::class, 'datatables'])->name('status.list')->middleware('can:view statuses');
});

require __DIR__ . '/auth.php';
