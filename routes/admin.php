<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DaySettingController;
use App\Http\Controllers\Dashboard\DurationController;
use App\Http\Controllers\Dashboard\ImageSettingController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\MealController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\MenuItemController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProgramController;
use App\Http\Controllers\Dashboard\ShippingController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\UsersController;
use Illuminate\Support\Facades\Route;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    Route::prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('welcome');
        })->name('dashboard');

        Route::prefix('meal')->group(function () {
            Route::get('/index', [MealController::class, 'index'])->name('meal.index');
            Route::get('/addMeal', [MealController::class, 'addMeal'])->name('meal.addMeal');
            Route::post('/storeMeal', [MealController::class, 'storeMeal'])->name('meal.store');
            Route::get('/editMeal/{id}', [MealController::class, 'editMeal'])->name('meal.edit');
            Route::post('/updateMeal/{id}', [MealController::class, 'updateMeal'])->name('meal.update');
            Route::get('/archiveMeal/{id}', [MealController::class, 'archiveMeal'])->name('meal.archive');
            Route::get('/archiveMealList', [MealController::class, 'archiveMealList'])->name('meal.archived');
            Route::get('/restoreMeal/{id}', [MealController::class, 'restoreMeal'])->name('meals.restore');
        });

        Route::prefix('duration')->group(function () {
            Route::get('/index', [DurationController::class, 'index'])->name('duration.index');
            Route::get('/addDuration', [DurationController::class, 'addDuration'])->name('duration.addDuration');
            Route::post('/storeDuration', [DurationController::class, 'storeDuration'])->name('duration.store');
            Route::get('/editDuration/{id}', [DurationController::class, 'editDuration'])->name('duration.edit');
            Route::post('/updateDuration/{id}', [DurationController::class, 'updateDuration'])->name('duration.update');
            Route::get('/archiveDuration/{id}', [DurationController::class, 'archiveDuration'])->name('duration.archive');
            Route::get('/archiveDurationList', [DurationController::class, 'archiveDurationList'])->name('duration.archived');
            Route::get('/restoreDuration/{id}', [DurationController::class, 'restoreDuration'])->name('duration.restore');
        });

        Route::prefix('category')->group(function () {
            Route::get('/index/{id?}', [CategoryController::class, 'index'])->name('category.index');
            Route::get('/dataTable/{id?}', [CategoryController::class, 'getData'])->name('category.dataTable');
            Route::get('/addCategory/{id?}', [CategoryController::class, 'addCategory'])->name('category.addCategory');
            Route::post('/storeCategory/{id?}', [CategoryController::class, 'storeCategory'])->name('category.store');
            Route::get('/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('category.edit');
            Route::post('/updateCategory/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');
            Route::get('/archiveCategory/{id}', [CategoryController::class, 'archiveCategory'])->name('category.archive');
            Route::get('/archiveCategoryList', [CategoryController::class, 'archiveCategoryList'])->name('category.archived');
            Route::get('/getArchivedCategory/{id?}', [CategoryController::class, 'getArchivedCategory'])->name('category.archivedData');
            Route::get('/restoreCategory/{id}', [CategoryController::class, 'restoreCategory'])->name('category.restore');
        });

        Route::prefix('items')->group(function () {
            Route::get('/index', [ItemController::class, 'index'])->name('item.index');
            // Route::get('/dataTable',[ItemController::class,'getItems'])->name('item.dataTable');
            Route::get('/filter', [ItemController::class, 'filter'])->name('item.filter');
            Route::get('/addItem', [ItemController::class, 'addItem'])->name('item.addItem');
            Route::get('/getSubCategory/{id}', [ItemController::class, 'getSubCategory'])->name('item.getSubCategory');
            Route::get('/getSubSubCategory/{id}', [ItemController::class, 'getSubSubCategory'])->name('item.getSubSubCategory');
            Route::post('/storeItem', [ItemController::class, 'storeItem'])->name('item.storeItem');
            Route::get('/editItem/{id}', [ItemController::class, 'editItem'])->name('item.edit');
            Route::post('/updateItem/{id}', [ItemController::class, 'updateItem'])->name('item.update');
            Route::get('/archiveItem/{id}', [ItemController::class, 'archiveItem'])->name('item.archive');
            Route::get('/archiveItemList', [ItemController::class, 'archiveItemList'])->name('item.archived');
            Route::get('/getArchivedItem', [ItemController::class, 'getArchivedItem'])->name('item.archivedData');
            Route::get('/restoreItem/{id}', [ItemController::class, 'restoreItem'])->name('item.restore');
        });

        Route::prefix('menu')->group(function () {
            Route::get('/index', [MenuController::class, 'index'])->name('menu.index');
            Route::get('/dataTable', [MenuController::class, 'getMenu'])->name('menu.dataTable');
            Route::get('/addMenu', [MenuController::class, 'addMenu'])->name('menu.addMenu');
            Route::post('/storeMenu', [MenuController::class, 'storeMenu'])->name('menu.store');
            Route::get('/editMenu/{id}', [MenuController::class, 'editMenu'])->name('menu.edit');
            Route::post('/updateMenu/{id}', [MenuController::class, 'updateMenu'])->name('menu.update');
            Route::get('/archiveMenu/{id}', [MenuController::class, 'archiveMenu'])->name('menu.archive');
            Route::get('/archiveMenuList', [MenuController::class, 'archiveMenuList'])->name('menu.archived');
            Route::get('/getArchivedMenu', [MenuController::class, 'getArchivedMenu'])->name('menu.archivedData');
            Route::get('/restoreMenu/{id}', [MenuController::class, 'restoreMenu'])->name('menu.restore');
        });

        Route::prefix('menuItems')->group(function () {
            Route::get('/index/{menu}', [MenuItemController::class, 'index'])->name('menuItem.index');
            Route::get('/datatable/{id}', [MenuItemController::class, 'getMenuItems'])->name('menu.getItems');
            Route::get('/getItem/{id}', [MenuItemController::class, 'getItem'])->name('menuItem.getItem');
            Route::post('/storeItem', [MenuItemController::class, 'storeItem'])->name('menuItem.storeItem');

            Route::get('/archiveItem/{id}', [MenuItemController::class, 'archiveItem'])->name('menuItem.archive');

            Route::get('/archiveMenuItemList/{id}', [MenuItemController::class, 'archiveMenuItemList'])->name('menuItem.archiveMenuItemList');
            Route::get('/archivedList/{id}', [MenuItemController::class, 'archivedList'])->name('menuItem.archivedList');
            Route::get('/restoreMenuItem/{id}', [MenuItemController::class, 'restoreMenuItem'])->name('menuItem.restoreMenuItem');
        });

        Route::prefix('program')->group(function () {
            Route::get('/index', [ProgramController::class, 'index'])->name('program.index');
            Route::get('/addProgram', [ProgramController::class, 'addProgram'])->name(('program.addProgram'));
            Route::get('/dataTable', [ProgramController::class, 'getDuration'])->name('duration.dataTable');
            Route::post('/storeProgram', [ProgramController::class, 'storeProgram'])->name('program.store');
            Route::get('/getProgram', [ProgramController::class, 'getProgram'])->name('program.dataTable');
            Route::get('/editProgram/{id}', [ProgramController::class, 'editProgram'])->name('program.editProgram');
            Route::post('/updateProgram/{id}', [ProgramController::class, 'updateProgram'])->name('program.updateProgram');
            Route::get('/archiveProgramList', [ProgramController::class, 'archiveProgramList'])->name('program.archiveProgramList');
            Route::get('/archiveProgramDataTable', [ProgramController::class, 'getArchiveProgram'])->name('program.archiveProgramDataTable');
            Route::get('/restoreProgram/{id}', [ProgramController::class, 'restoreProgram'])->name('program.restoreProgram');

            Route::get('/programDetails/{id}', [ProgramController::class, 'programDetails'])->name('program.details');
            Route::get('/programArchive/{id}', [ProgramController::class, 'programArchive'])->name('program.archive');
            Route::get('/editProgramDetails/{id}', [ProgramController::class, 'editProgramDetails'])->name('program.editProgramDetails');
            Route::post('/updateProgramDetails/{id}', [ProgramController::class, 'updateProgramDetails'])->name('program.updateProgramDetails');

            Route::get('/programMealArchive/{id}', [ProgramController::class, 'programMealArchive'])->name('program.mealArchive');
            Route::get('/programMealArchiveList/{id}', [ProgramController::class, 'programMealArchiveList'])->name('program.mealArchiveList');
            Route::get('/restoreProgramMeal/{id}', [ProgramController::class, 'restoreProgramMeal'])->name('program.restoreProgramMeal');
            Route::get('/api/durations/{mealId}', [ProgramController::class, 'getDuration'])->name('api.durations');

            Route::post('/addSingleMeal', [ProgramController::class, 'addSingleMeal'])->name('program.storeSingleMeal');
        });

        Route::prefix('slider')->group(function () {
            Route::get('/index', [SliderController::class, 'index'])->name('slider.index');
            Route::get('/dataTable', [SliderController::class, 'getSlider'])->name('slider.dataTable');
            Route::get('/addSlider', [SliderController::class, 'addSlider'])->name('slider.addSlider');
            Route::post('/storeSlider', [SliderController::class, 'storeSlider'])->name('slider.store');
            Route::get('/editSlider/{id}', [SliderController::class, 'editSlider'])->name('slider.edit');
            Route::post('/updateSlider/{id}', [SliderController::class, 'updateSlider'])->name('slider.update');
            Route::get('/deleteSlider/{id}', [SliderController::class, 'deleteSlider'])->name('slider.delete');
        });

        Route::prefix('Users')->group(function () {
            Route::get('/admins', [UsersController::class, 'admins'])->name('admins.list');
            Route::get('/dataTable/{type?}', [UsersController::class, 'dataTable'])->name('admins.dataTable');
            Route::get('/customers', [UsersController::class, 'customers'])->name('customers.list');
            Route::get('/staff', [UsersController::class, 'staff'])->name('staff.list');
            Route::get('/addUser', [UsersController::class, 'addUser'])->name('admins.addUser');
            Route::post('/storeUser', [UsersController::class, 'storeUser'])->name('admins.storeUser');

            Route::get('/editUser/{id}', [UsersController::class, 'editUser'])->name('user.edit');
            Route::post('/updateUser/{id}', [UsersController::class, 'updateUser'])->name('user.update');
            Route::get('/updateStatus/{user}', [UsersController::class, 'updateStatus'])->name('user.status');
            Route::get('/profile/{id}', [UsersController::class, 'profile'])->name('profile.index');
            Route::post('/profile/{id}', [UsersController::class, 'update'])->name('profile.update');
        });

        Route::prefix('daySetting')->group(function () {
            Route::get('/index', [DaySettingController::class, 'index'])->name('daySetting.index');
            Route::get('/dataTable', [DaySettingController::class, 'getDays'])->name('daySetting.dataTable');
            Route::get('/updateStatus/{daySetting}', [DaySettingController::class, 'updateStatus'])->name('daySetting.status');
        });

        Route::prefix('shipping')->group(function () {
            Route::get('/index', [ShippingController::class, 'index'])->name('shipping.index');
            Route::get('/dataTable', [ShippingController::class, 'getGovernorates'])->name('shipping.dataTable');
            Route::get('/updateStatus/{governorateId}', [ShippingController::class, 'updateStatus'])->name('shipping.status');
            Route::get('/area/{id}', [ShippingController::class, 'area'])->name('shipping.area');
            Route::get('/getArea/{id}', [ShippingController::class, 'getArea'])->name('shipping.getArea');
            Route::get('/updateAreaStatus/{areaId}', [ShippingController::class, 'updateAreaStatus'])->name('shipping.areaStatus');
            Route::post('/storeArea', [ShippingController::class, 'storeArea'])->name('shipping.storeArea');
            Route::post('/storeGovernorate', [ShippingController::class, 'storeGovernorate'])->name('shipping.storeGovernorate');
            Route::get('/ShippingTime', [ShippingController::class, 'ShippingTime'])->name('shipping.time');

            Route::get('/timeDataTable', [ShippingController::class, 'timeDataTable'])->name('shipping.timeDataTable');
            Route::get('/updateTimeStatus/{timeId}', [ShippingController::class, 'updateTimeStatus'])->name('shipping.timeStatus');

            Route::get('/getSubTypes/{id}', [ShippingController::class, 'getSubTypes'])->name('shipping.getSubTypes');
            Route::post('/storeShippingTime', [ShippingController::class, 'storeShippingTime'])->name('shipping.storeShippingTime');

        });



        Route::prefix('image')->group(function () {
            Route::get('/imageSetting/edit', [ImageSettingController::class, 'editImageSetting'])->name('editImageSetting');
            Route::post('/imageSetting/update', [ImageSettingController::class, 'updateImageSetting'])->name('updateImageSetting');
        });
        Route::prefix('order')->group(function () {
            Route::get('/index', [OrderController::class, 'index'])->name('order.index');
            Route::get('/dataTable', [OrderController::class, 'getOrder'])->name('order.dataTable');
            Route::get('/orderDetails/{id}', [OrderController::class, 'orderDetails'])->name('order.orderDetails');
        });
    });
});
