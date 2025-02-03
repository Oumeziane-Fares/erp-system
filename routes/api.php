<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\StockMovementController;
use App\Http\Controllers\Api\CategoryController;

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


// Apply JWT authentication middleware to all routes
Route::middleware('auth:api')->group(function () {
    // Product routes
    Route::prefix('products')->group(function () {
        // Routes accessible by users with 'view-products' permission
        Route::middleware('permission:view-products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/{id}', [ProductController::class, 'show']);
        });

        // Routes accessible by users with 'create-products' permission
        Route::middleware('permission:create-products')->group(function () {
            Route::post('/', [ProductController::class, 'store']);
        });

        // Routes accessible by users with 'update-products' permission
        Route::middleware('permission:update-products')->group(function () {
            Route::put('/{id}', [ProductController::class, 'update']);
        });

        // Routes accessible by users with 'delete-products' permission
        Route::middleware('permission:delete-products')->group(function () {
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });
    });

    // Supplier routes
    Route::prefix('suppliers')->group(function () {
        // Routes accessible by users with 'view-suppliers' permission
        Route::middleware('permission:view-suppliers')->group(function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::get('/{id}', [SupplierController::class, 'show']);
        });

        // Routes accessible by users with 'create-suppliers' permission
        Route::middleware('permission:create-suppliers')->group(function () {
            Route::post('/', [SupplierController::class, 'store']);
        });

        // Routes accessible by users with 'update-suppliers' permission
        Route::middleware('permission:update-suppliers')->group(function () {
            Route::put('/{id}', [SupplierController::class, 'update']);
        });

        // Routes accessible by users with 'delete-suppliers' permission
        Route::middleware('permission:delete-suppliers')->group(function () {
            Route::delete('/{id}', [SupplierController::class, 'destroy']);
        });
    });

    // Stock movement routes
    Route::prefix('products/{productId}/suppliers/{supplierId}')->group(function () {
        // Routes accessible by users with 'add-stock' permission
        Route::middleware('permission:add-stock')->group(function () {
            Route::post('/add-stock', [StockMovementController::class, 'addStock']);
        });

        // Routes accessible by users with 'remove-stock' permission
        Route::middleware('permission:remove-stock')->group(function () {
            Route::post('/remove-stock', [StockMovementController::class, 'removeStock']);
        });
    });

    // Category routes
    Route::prefix('categories')->group(function () {
        // Routes accessible by users with 'view-categories' permission
        Route::middleware('permission:view-suppliers')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/all', [CategoryController::class, 'allCategories']);
            Route::get('/{id}', [CategoryController::class, 'show']);
        });

        // Routes accessible by users with 'create-categories' permission
        Route::middleware('permission:view-suppliers')->group(function () {
            Route::post('/', [CategoryController::class, 'store']);
        });

        // Routes accessible by users with 'update-categories' permission
        Route::middleware('permission:update-categories')->group(function () {
            Route::put('/{id}', [CategoryController::class, 'update']);
        });

        // Routes accessible by users with 'delete-categories' permission
        Route::middleware('permission:delete-categories')->group(function () {
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });
    });
});