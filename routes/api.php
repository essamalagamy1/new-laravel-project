<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BunnyStreamWebhookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SiteSettingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::any('/webhooks/bunny-stream', [BunnyStreamWebhookController::class, 'handle']);

// guest routes
Route::controller(GuestController::class)->middleware('throttle:10,1')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/social-login', 'socialLogin');
    Route::post('/send/code', 'sendCode')->middleware('throttle:50,1');
    Route::post('/verify-code', 'verifyCode')->middleware('throttle:50,1');
    Route::post('/reset/password', 'resetPassword');
});
Route::get('/site-setting', SiteSettingController::class);
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'categories');
    Route::get('/sub-categories', 'subCategories');
});

Route::controller(BannerController::class)->group(function () {
    Route::get('/banners', 'index');
    Route::get('/single-banner', 'singleBanners');
});

Route::middleware('auth:sanctum')->group(function () {
    // notifications
    Route::prefix('notifications')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'index');
        Route::put('/read', 'read');
        Route::put('/read-all', 'readAll');
        Route::delete('/delete', 'delete');
        Route::get('/unread/count', 'unreadNotificationCount');
        Route::put('/toggle-disable', 'toggleDisable');
    });

    // profile
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index');
        Route::put('/update', 'update');
        Route::put('/update-password', 'updatePassword');
        Route::put('/update-language', 'updateLanguage');
        Route::post('/logout', 'logout');
        Route::delete('/delete-account', 'deleteAccount');
        Route::put('/remove/instructor-code', 'removeInstructorCode');
    });

    // payment methods + checkout
    Route::prefix('payment')->controller(PaymentController::class)->group(function () {
        Route::get('checkout/payment-methods', 'paymentMethods');
        Route::post('/checkout', 'checkout');
    });

});
// payment methods + checkout
Route::prefix('payment')->controller(PaymentController::class)->group(function () {
    Route::any('/success', 'success');
    Route::any('/failure', 'failure');
    Route::any('/pending', 'pending');
    Route::any('/webhook', 'webhook');
});
