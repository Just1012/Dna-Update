<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\IndexController;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    require __DIR__ . '/auth.php';

    Route::get('/', [IndexController::class, 'index'])->name('front.index');
    Route::get('/get-sub-categories/{categoryId?}', [IndexController::class, 'getSubCategory']);
    Route::get('/get-items/{categoryId?}/{subCategoryId?}', [IndexController::class, 'getItems']);

    Route::get('/allProgram', [IndexController::class, 'allProgram'])->name('front.allProgram');
    Route::get('/programDetails/{id}', [IndexController::class, 'programDetails'])->name('front.programDetails');
    Route::post('/storeProgramMeals/{id}', [IndexController::class, 'storeProgramMeals'])->name('front.storeProgramMeals');
    Route::get('/programDuration', [IndexController::class, 'programDuration'])->name('front.programDuration');

    Route::post('/save/to/card', [IndexController::class, 'save_card'])->name('front.save.card');
    Route::get('/getDays', [IndexController::class, 'getDays'])->name('days.dataTable');
    Route::post('/storeOrder', [IndexController::class, 'storeOrder'])->name('front.storeOrder');
    Route::get('/checkout', [IndexController::class, 'checkout'])->name('checkout');

    // =========================== Auth Route ==================================================================
    Route::get('/register', [AuthController::class, 'register'])->name('front.register');
    Route::post('/register', [AuthController::class, 'store'])->name('front.register.store');
    Route::get('/otp', [AuthController::class, 'otp'])->name('front.otp.index');
    Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('front.otp.post');
    Route::get('/front/login', [AuthController::class, 'login_view'])->name('front.login');
    Route::post('/front/login', [AuthController::class, 'login'])->name('front.login.store');
    Route::post('/front/logout', [AuthenticatedSessionController::class, 'logOut'])->name('front.logout');
    Route::post('/front/login/checkout', [IndexController::class, 'login'])->name('front.checkout.login.store');

    Route::post('/front/register/checkout', [IndexController::class, 'register'])->name('front.checkout.register.store');
    Route::get('/area/{id}', [IndexController::class, 'getSubTypes'])->name('front.area')->middleware('auth');
    Route::get('/shipping/{governorate_id}/{area_id}', [IndexController::class, 'getShippingDetails'])->name('front.shipping')->middleware('auth');
    Route::post('/apply-coupon', [IndexController::class, 'apply_copon'])->name('apply.coupon')->middleware('auth');


    Route::get('/about', [IndexController::class, 'about'])->name('about');

    Route::get('/Privacy', [IndexController::class, 'privacy'])->name('privacy');




    // =========================== Profile Route ==================================================================
    Route::get('/user-profile/{id}', [ProfileController::class, 'index'])->name('front.profile');
    Route::post('/profile/{id}', [ProfileController::class, 'update'])->name('front.user.update');
    Route::get('/getOrderData/{id}', [ProfileController::class, 'getOrderData']);

    Route::Post('/programDuration', [IndexController::class, 'store_duration'])->name('front.programDuration_store');

    Route::post('/programDuration/store/items',[IndexController::class, 'store_items'])->name('front.store.items');

    // Route::get('/dashboard', function () {
    //     return view('welcome');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });
});
