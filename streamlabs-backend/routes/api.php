<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('auth/login', [AuthController::class, 'authenticate']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('jwt.verify');

Route::get('user/dashboard', [DashboardController::class, 'dashboardStats'])->middleware('jwt.verify');
Route::get('user/notifications', [NotificationController::class, 'unreadNotifications'])->middleware('jwt.verify');
Route::put('user/notifications/toggle_read/{notification_id}', [NotificationController::class, 'toggleReadStatus'])->middleware('jwt.verify');
