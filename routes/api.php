<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');


// Protected routes (require JWT authentication)
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello, World!']);
    });

    // Routes accessible only to users with the 'admin' role
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', function () {
            return response()->json(['message' => 'Welcome to the Admin Dashboard']);
        });
    });
    
});


//These routes will be accessible only to users with specific roles
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Routes accessible only to users with the 'admin' role
    Route::get('/admin-dashboard', function () {
        return response()->json(['message' => 'Welcome to the Admin Dashboard']);
    });
});
//These routes will be accessible only to users with specific permissions
Route::middleware(['auth:api', 'permission:edit-posts'])->group(function () {
    // Routes accessible only to users with the 'edit-posts' permission
    Route::get('/edit-posts', function () {
        return response()->json(['message' => 'You can edit posts']);
    });
});