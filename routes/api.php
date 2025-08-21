<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Fun;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
 


Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'App\Http\Controllers\Api\UserAuth@login');
    Route::post('/register', 'App\Http\Controllers\Api\UserAuth@register');
    Route::post('/logout', 'App\Http\Controllers\Api\UserAuth@logout');
    Route::post('/refresh', 'App\Http\Controllers\Api\UserAuth@refresh');
    Route::get('/user-profile', 'App\Http\Controllers\Api\UserAuth@userProfile');    
    Route::get('/profile', 'App\Http\Controllers\Api\UserAuth@userProfile');    
    Route::get('/History', 'App\Http\Controllers\Api\UserAuth@accountHistory');    
    Route::get('/rewardHistory', 'App\Http\Controllers\Api\UserAuth@rewardHistory');    
    
    Route::post('/api', 'App\Http\Controllers\Api\Fun@api');    
    Route::get('/promoBanner', 'App\Http\Controllers\Api\Fun@promoBanner');    
    Route::get('/popupBanner', 'App\Http\Controllers\Api\Fun@popupBanner');    
    Route::get('/ofWeb', 'App\Http\Controllers\Api\Fun@ofWeb');    
    Route::get('/ofVideo', 'App\Http\Controllers\Api\Fun@ofVideo');    
    Route::get('/ofCustom', 'App\Http\Controllers\Api\Fun@ofCustom');    
    Route::get('/ofCustomProgress', 'App\Http\Controllers\Api\Fun@ofCustomProgress');    
    Route::get('/funGame', 'App\Http\Controllers\Api\Fun@funGame');    
    Route::get('/faq/{type}', 'App\Http\Controllers\Api\Fun@funfaq');    
    Route::get('/store', 'App\Http\Controllers\Api\Fun@funCoinstore');    
    Route::get('/funOfferwalls', 'App\Http\Controllers\Api\Fun@funOfferwalls');    
    Route::get('/funrewards/{id}', 'App\Http\Controllers\Api\Fun@funrewards');    
    Route::get('/rewardCat', 'App\Http\Controllers\Api\Fun@rewardCat');    
    Route::get('/countTask/{type}', 'App\Http\Controllers\Api\Fun@countTask');    
    Route::post('/createPromo', 'App\Http\Controllers\Api\Fun@createPromo');    
    Route::get('/user_noti', 'App\Http\Controllers\Api\Fun@notiMsg');    
    Route::get('/dailyoffer', 'App\Http\Controllers\Api\Fun@dailyoffer');    
    Route::get('/coinstores', 'App\Http\Controllers\Api\Fun@funCoinstore');    
    Route::post('/submit_dailyoffer', 'App\Http\Controllers\Api\Fun@submit_dailyoffer');    
    Route::post('/verifyPay', 'App\Http\Controllers\Api\Fun@verifyPay');    
    Route::get('/supportTicket', 'App\Http\Controllers\Api\Fun@supportTicket');    
    Route::get('/leaderboard', 'App\Http\Controllers\Api\Fun@leaderboard');    
    Route::post('/create_ticket', 'App\Http\Controllers\Api\Fun@createSupportTicket');    
});

    Route::post('/config', 'App\Http\Controllers\Api\Fun@config');    
    Route::post('/reset_password', 'App\Http\Controllers\Api\UserAuth@reset_password');    
    Route::post('/verify_otp', 'App\Http\Controllers\Api\UserAuth@verify_otp');    
    Route::post('/update_password', 'App\Http\Controllers\Api\UserAuth@update_password');    
    Route::get('/testapp', 'App\Http\Controllers\Api\Fun@testapp');    
    Route::get('/cronjob/{secret}', 'App\Http\Controllers\Api\Fun@cronjob');
    
    Route::get('/offer_custom','App\Http\Controllers\Api\Fun@offer_custom');
    Route::get('/offer_cr/{id}','App\Http\Controllers\Api\Off@crofferwall');
