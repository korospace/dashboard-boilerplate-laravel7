<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
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

Route::group(['prefix' => 'v1'], function () {

    /**
     * Login With Cookie
     *
     * - url      : /api/v1/login_cookie
     * - form-data: email, password
     */
    Route::post('login_cookie', [LoginController::class, 'loginWithCookie']);

    /**
     * Forgot Password
     *
     * - url      : /api/v1/forgot_pass
     * - form-data: email
     */
    Route::post('forgot_pass', [NotificationController::class, 'forgotPassword']);

    /**
     *  Edit Profile
     *
     * - url      : /api/v1/edit_profile
     * - form-data: email, name, new_password
     */
    Route::put('edit_profile', [DashboardController::class, 'editProfile'])->middleware('ApiGuard');

    /**
     * User Endpoint
     *
     * - CRUD master data user
     */
    Route::group(['prefix' => 'user', 'middleware' => ['ApiGuard', 'ApiForSuperadmin']], function () {
        /**
         * Get With Datatable
         *
         * - url    : /api/v1/user/datatable
         * - params : none
         */
        Route::get('/datatable', [UserController::class, 'getUserDataTable']);

        /**
         * Create New User
         *
         * - url    : /api/v1/user/create
         * - form-data : name, email, password, level_id, site_id
         */
        Route::post('/create', [UserController::class, 'createUser']);

        /**
         * Update Site
         *
         * - url    : /api/v1/site/update
         * - form-data : name, email, new_password, level_id, site_id
         */
        Route::put('/update', [UserController::class, 'updateUser']);

        /**
         * Delete User
         *
         * - url    : /api/v1/User/delete/{id}
         * - query-param: id
         */
        Route::delete('/delete/{id}', [UserController::class, 'deleteUser']);
    });
});
