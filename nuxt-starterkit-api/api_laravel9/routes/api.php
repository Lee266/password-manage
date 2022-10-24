<?php

use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Admin\AdminListController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Meeting\MeetingListController;
use App\Http\Controllers\Admin\UserSample\UserSampleController;
use App\Http\Controllers\Admin\User\AdminUserListController;
use App\Http\Controllers\User\Auth\UserAuthController;
use App\Http\Controllers\Admin\Sample\SampleController;
use App\Http\Controllers\Admin\Activity\LogAdminActivityController;
use App\Http\Controllers\Password\Manage\PasswordManageController;
use Illuminate\Support\Facades\Route;

//// User routes ////
Route::prefix('user')->name('user.')->namespace('User')->group(function () {

    // Open routes
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);

    // Protected routes
    Route::middleware(['auth:user'])->group(function () {
        Route::get('/account', [UserAuthController::class, 'account']);
    });

});

//// Admin routes ////
Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

    // Open routes
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse']);
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'checkTokenExpired']);
    Route::post('/password/reset', [ResetPasswordController::class, 'sendResetResponse']);

    // Protected routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/account', [AdminAuthController::class, 'account']);

        Route::prefix('admin')->namespace('Admin')->group(function () {
            Route::get('/{id}', [AdminController::class, 'edit']);
            Route::post('/create', [AdminController::class, 'store']);
            Route::post('/update/{id}', [AdminController::class, 'update']);
            Route::post('/uniqueEmail', [AdminController::class, 'uniqueEmail']);

            Route::prefix('list')->group(function () {
                Route::get('/filter', [AdminListController::class, 'filter']);
                Route::get('/resources', [AdminListController::class, 'resources']);
            });
        });

        Route::prefix('user')->namespace('User')->group(function () {

            Route::prefix('list')->group(function () {
                Route::get('/filter', [AdminUserListController::class, 'filter']);
                Route::get('/resources', [AdminUserListController::class, 'resources']);
            });
        });

        Route::prefix('sample')->namespace('Sample')->group(function () {
            Route::post('/form', [SampleController::class, 'store']);
            Route::get('/form', [SampleController::class, 'create']);
            Route::get('/form/postcode', [SampleController::class, 'search']);
        });

        Route::prefix('user-sample')->namespace('UserSample')->group(function () {
            Route::get('/filter', [UserSampleController::class, 'filter']);
        });

        Route::prefix('activity')->namespace('Activity')->group(function () {
            Route::prefix('list')->group(function () {
                Route::get('/filter', [LogAdminActivityController::class, 'filter']);
                Route::get('/resources', [LogAdminActivityController::class, 'resources']);
            });
        });

        Route::prefix('meeting')->namespace('Meeting')->group(function () {
            Route::prefix('list')->group(function () {
                Route::get('/filter', [MeetingListController::class, 'filter']);
                Route::get('/resources', [MeetingListController::class, 'resources']);
            });

            Route::delete('/delete/{id}', [MeetingListController::class, 'destroy']);
            Route::post('/uploadCSV', [MeetingListController::class, 'store']);
            Route::get('/csvDownload', [MeetingListController::class, 'csvDownload']);
            Route::get('/exportCsv', [MeetingListController::class, 'exportCsv']);
        });

    });

});

// // password route
Route::prefix('password')->name('password.')->namespace('Password')->group(function () {
    // Protected routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::prefix('manage')->namespace('Manage')->group(function () {
            Route::post('/create', [PasswordManageController::class, 'create'])->name('passwordManageCreate');
            Route::post('/destroy', [PasswordManageController::class, 'destroy'])->name('passwordManageDestroy');
            Route::get('/filter', [PasswordManageController::class, 'filter'])->name('passwordManageFilter');
            Route::get('/resources', [PasswordManageController::class, 'resources'])->name('passwordManageResources');
            Route::post('/update/{id}', [PasswordManageController::class, 'update'])->name('passwordManageUpdate');
            Route::get('/{id}', [PasswordManageController::class, 'edit'])->name('passwordManageEdit');
        });
    });
    Route::get('/update', [PasswordManageController::class, 'update'])->name('testCode');
});
