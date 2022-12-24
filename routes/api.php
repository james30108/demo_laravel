<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductQuantityController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PayReferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\LinerController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;

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

// register & login
Route::controller(AuthController::class)->group(function(){
    Route::post('auth/member/register', 'member_register');
    Route::post('auth/member/login', 'member_login');
    Route::post('auth/admin/register', 'admin_register');
    Route::post('auth/admin/login', 'admin_login');
});

// member
Route::group(['middleware' => ['auth:sanctum', 'ability:member']], function() {
    Route::get('auth/member/me', [AuthController::class, 'member_me']);
    Route::post('auth/member/logout', [AuthController::class, 'member_logout']);
});

// admin
Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function() {
    Route::get('auth/admin/me', [AuthController::class, 'admin_me']);
    Route::post('auth/admin/logout', [AuthController::class, 'admin_logout']);

    Route::controller(AdminController::class)->prefix('admin')->group(function () {
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/update', 'update');
        Route::post('/update_password', 'updatePassword');
        Route::post('/language', 'language');
    });

    Route::controller(MemberController::class)->prefix('member')->group(function () {
        Route::post('/position', 'position');
        Route::post('/store', 'store');
        Route::post('/status', 'status');
        Route::post('/delete', 'delete');
    });

    Route::controller(LinerController::class)->prefix('liner')->group(function () {
        Route::post('/type', 'type');
        Route::post('/status', 'status');
        Route::post('/direct', 'direct');
    });

    Route::controller(ProductTypeController::class)->prefix('product_type')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    });

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/update', 'update');
        Route::post('/status', 'status');
        Route::post('/update_image', 'updateImage');
        Route::post('/delete_image', 'deleteImage');
        Route::post('/delete', 'delete');
    });

    Route::controller(ProductQuantityController::class)->prefix('product_quantity')->group(function () {
        Route::post('/create', 'create');
        Route::post('/detail', 'detail');
    });

    Route::controller(ReportController::class)->prefix('report')->group(function () {
        Route::post('/sale', 'sale');
        Route::post('/commission', 'commission');
    });

    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::post('/order', 'order');
    });

    Route::controller(ConfigController::class)->prefix('config')->group(function () {
        Route::post('/store', 'store');
        Route::post('/update', 'update');
        Route::post('/commission', 'commission');
    });

    Route::controller(PositionController::class)->prefix('position')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/update', 'update');
    });

    Route::controller(WithdrawController::class)->prefix('withdraw')->group(function () {
        Route::post('/status', 'status');
    });

});


// All
Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::controller(MemberController::class)->prefix('member')->group(function () {
        Route::post('/update_profile', 'updateProfile');
        Route::post('/update_address', 'updateAddress');
        Route::post('/update_bank', 'updateBank');
        Route::post('/update_password', 'updatePassword');
        Route::post('/detail', 'detail');
        Route::post('/language', 'language');
    });

    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
        Route::post('/delete_all', 'deleteAll');
    });

    Route::controller(PayReferController::class)->prefix('pay_refer')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/status', 'status');
    });

    Route::controller(OrderController::class)->prefix('order')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/delete', 'delete');
    });

    Route::controller(TransferController::class)->prefix('transfer')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
    });

    Route::controller(DepositController::class)->prefix('deposit')->group(function () {
        Route::post('/create', 'create');
        Route::post('/status', 'status');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
    });

    Route::controller(WithdrawController::class)->prefix('withdraw')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
    });

    Route::controller(ContactController::class)->prefix('contact')->group(function () {
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/status', 'status');
    });

});
