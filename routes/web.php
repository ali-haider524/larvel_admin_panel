<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Users_;
use App\Http\Controllers\Transaction_;
use App\Http\Controllers\Withdrawal_;
use App\Http\Controllers\WebArticle;
use App\Http\Controllers\VideoZone;
use App\Http\Controllers\Notification;
use App\Http\Controllers\Setting;
use App\Http\Controllers\Offers;
use App\Http\Controllers\Offerwall;
use App\Http\Controllers\Extras;
use App\Http\Controllers\Home;

//new 
use App\Http\Controllers\Alias_;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('/dashboard', [Home::class,'index']);

    Route::controller(Users_::class)->group(function () {
        Route::get('users', 'index');
        Route::get('users/banned', 'BanIndex');
        Route::get('users/search/{query}', 'searchQuery');
        Route::get('users/top-earning-user', 'TopIndex');
        Route::get('users/delete/{id}', 'removeUser');
        Route::get('/clear_history/{id}', 'removeTransaction');
        Route::post('/users/ban', 'updateStatus');
        Route::post('/users/coins', 'updateCoin');
    });

    Route::controller(Alias_::class)->group(function () {
        Route::get('/alias-management', 'index');
        Route::get('/alias/add', 'createNew');
        Route::get('/alias/{type}', 'getAlias');
        Route::post('/alias/store', 'store');
        Route::get('/alias/edit/{id}', 'createEdit');
        Route::post('/alias/update', 'edit');
        Route::get('/alias/delete/{id}', 'destroy');
        Route::post('/alias/action', 'action');

    });

    Route::controller(Transaction_::class)->group(function () {
        Route::get('/all-transaction', 'index');
        Route::get('/user-track/{id}', 'userProfile');
        Route::get('/coinstore-transaction', 'coinstoreTransaction');
   
    });

    Route::controller(Withdrawal_::class)->group(function () {
        Route::post('/withdrawal/action', 'action');

        //pending withdrawal
        Route::get('/withdrawal/pending', 'indexPending');
        Route::get('/withdrawal/completed', 'indexComplete');
        Route::get('/withdrawal/rejected', 'indexReject');
        Route::post('/withdrawal/status/update', 'statusUpdate');
        Route::get('/withdrawal/delete/{id}', 'removeWithdrawal');
        
        
        Route::get('/withdrawal', 'index');
        Route::post('/withdrawal/create', 'store');
        Route::get('/withdrawal/edit/{id}', 'edit');
        Route::post('/withdrawal/update', 'update');
        Route::get('/withdrawal/deleteCat/{id}', 'destroy');
        Route::post('/withdrawal/actionCat', 'actionCat');
        
        Route::get('/withdrawal/method/{id}', 'indexData');
        Route::get('/withdrawal/method/add/{id}', 'addData');
        Route::post('/withdrawal/method/create', 'storeData');
        Route::get('/withdrawal/method/edit/{id}', 'editData');
        Route::post('/withdrawal/method/update', 'updateData');
        Route::get('/withdrawal/method/delete/{id}', 'deleteMethod');
        Route::post('/withdrawal/method/action', 'actionMethod');

    });


    Route::controller(WebArticle::class)->group(function () {
        Route::get('/article/active', 'index');
        Route::get('/article/completed', 'indexComplete');
        Route::get('/promotion/article/approval', 'pendingApproval');
        Route::get('/article/add', 'create');
        Route::post('/article/store', 'store');
        Route::get('/article/edit/{id}', 'edit');
        Route::get('/article/delete/{id}', 'destroy');
        Route::post('/article/update', 'update');
        Route::post('/article/action', 'action');
        Route::post('/promo_reject', 'rejectPromo');
    });

    Route::controller(VideoZone::class)->group(function () {
        Route::get('/videozone/active', 'index');
        Route::get('/videozone/completed', 'indexComplete');
        Route::get('/promotion/videozone/approval', 'pendingApproval');
        Route::get('/videozone/add', 'create');
        Route::post('/videozone/create', 'store');
        Route::get('/videozone/edit/{id}', 'edit');
        Route::post('/videozone/update', 'update');
        Route::get('/videozone/delete/{id}', 'destroy');
        Route::post('/videozone/action', 'action');
    });

    Route::controller(Offers::class)->group(function () {
        Route::get('/offers/active', 'index');
        Route::get('/offers/completed', 'indexComplete');
        Route::get('/offers/add', 'create');
        Route::post('/offers/create', 'store');
        Route::get('/offers/edit/{id}', 'edit');
        Route::post('/offers/update', 'update');
        Route::get('/offers/delete/{id}', 'destroy');
        Route::post('/offers/action', 'action');
    });
    

    Route::controller(Notification::class)->group(function () {
        Route::get('/push-notification', 'index');
        Route::post('/push-notification/send', 'norification_all');
        Route::post('/push-notification/user', 'notifyUser');
  
    });


    Route::controller(Setting::class)->group(function () {
        Route::get('/setting/general', 'index');
        Route::get('/setting/update-maintenance', 'indexMaintenance');
        Route::get('/setting/ads', 'indexAds');
        Route::get('/setting/app', 'indexApp');
        Route::get('/setting/admin-profile', 'indexAdmin');
        Route::get('/setting/fraud-prevention', 'indexFraud');
        Route::get('/setting/app-configuration', 'indexConfiguration');
        Route::post('/setting/update', 'update');
    });

    Route::controller(Offerwall::class)->group(function () {
        Route::get('/offerwall/sdk', 'index');
        Route::post('/offerwall/sdk/update', 'updateSdk');
        Route::get('/offerwall/sdk/edit/{id}', 'editsdk');

        Route::get('/offerwall/web', 'indexWeb');
        Route::get('/offerwall/web/create', 'createWeb');
        Route::view('/offerwall/web/add', 'offerwall/add-web');
        Route::post('/offerwall/web/create', 'createWeb');
        Route::post('/offerwall/web/update', 'updateWeb');
        Route::get('/offerwall/web/edit/{id}', 'editWeb');

        Route::get('/offerwall/api', 'indexApi');
        Route::post('/offerwall/api/create', 'createApi');
        Route::post('/offerwall/api/update', 'updateApi');
        Route::view('/offerwall/api/add', 'offerwall/add-api');
        Route::get('/offerwall/api/edit/{id}', 'editApi');

        Route::get('/offerwall/delete/{id}', 'destroyOfferwall');
        
        Route::post('/offerwall/action', 'action');
    });


    Route::controller(Extras::class)->group(function () {
        
        Route::get('/banner', 'index');
        Route::post('/banner/create', 'storeBanner');
        Route::get('/banner/edit/{id}', 'editBanner');
        Route::post('/banner/update', 'updateBanner');
        Route::get('/banner/delete/{id}', 'destroyBanner');
        Route::post('/banner/action', 'actionBanner');
        
        Route::get('/games', 'indexGame');
        Route::post('/games/create', 'storeGame');
        Route::get('/games/edit/{id}', 'editGame');
        Route::post('/games/update', 'updateGame');
        Route::get('/games/delete/{id}', 'destroyGame');
        Route::post('/games/action', 'actionGame');

        Route::get('/luckywheel', 'indexSpin');
        Route::post('/luckywheel/create', 'storeSpin');
        Route::get('/luckywheel/edit/{id}', 'editSpin');
        Route::post('/luckywheel/update', 'updateSpin');
        Route::get('/luckywheel/delete/{id}', 'destroySpin');
        
        Route::get('/faq', 'indexfaq');
        Route::post('/faq/create', 'storefaq');
        Route::get('/faq/edit/{id}', 'editfaq');
        Route::post('/faq/update', 'updatefaq');
        Route::get('/faq/delete/{id}', 'destroyfaq');
        Route::post('/faq/action', 'actionfaq');

        Route::get('/coinstore', 'indexStore');
        Route::post('/coinstore/create', 'storeCoin');
        Route::get('/coinstore/edit/{id}', 'editStore');
        Route::post('/coinstore/update', 'updateStore');
        Route::get('/coinstore/delete/{id}', 'destroyStore');
        Route::post('/coinstore/action', 'actionStore');
        
        Route::get('/dailyoffer','indexDaily');
        Route::view('/dailyoffer/add','dailyoffer/add');
        Route::post('/dailyoffer/create','storeDaily');
        Route::get('/dailyoffer/edit/{id}','editDaily');
        Route::get('/dailyoffer/view/{id}','viewDaily');
        Route::post('/dailyoffer/update','updateDaily');
        Route::get('/dailyoffer/delete/{id}','destroyDaily');
        Route::post('/dailyoffer/reject','rejectDaily');
        Route::get('/dailyoffer/approve/{id}','approveDaily');
        Route::post('/dailyoffer/action','actionDaily');
        Route::get('/dailyoffer/pending','pendingDaily');
        Route::get('/dailyoffer/approved','viewApproveDaily');

        
        Route::get('/support/ticket_active', 'activeTicket');
        Route::get('/support/ticket_closed', 'closedTicket');
        Route::get('/support/update/{status}/{id}', 'updateTicket');
        Route::post('/support/action','actionTicket');
    });
    
    



    Route::get('/logout', [SessionController::class, 'destroy']);
    Route::view('/login', 'dashboard')->name('sign-up');
});


Route::group(['middleware' => 'guest'], function () {

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/session', [SessionController::class, 'store']);
    Route::get('/login/forgot-password', [ChangePasswordController::class, 'create']);
    Route::post('/forgot-password', [ChangePasswordController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ChangePasswordController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
    Route::view('/', 'errors/403');
});
