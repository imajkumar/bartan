<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/add-new-img/{item_id}', 'HomeController@addGalleryImage')->name('addGalleryImageA');

Route::post('/checksms', 'CustomerController@checksms');

Route::post('/sendOtp', 'APIController@sendOtp')->name('sendOtp');
Route::post('/verifyOtp', 'APIController@verifyOtp')->name('verifyOtp');
Route::post('/saveCustomerProfileDetails', 'APIController@saveCustomerProfileDetails')->name('saveCustomerProfileDetails');
Route::get('/getcustomerProfileByUserId/{user_id}', 'APIController@getcustomerProfileByUserId')->name('getcustomerProfileByUserId');

Route::get('/register', 'APIController@register')->name('register');
Route::get('/login', 'APIController@login')->name('login');
Route::get('/afterPaymentByLinkCron', 'APIController@afterPaymentByLinkCron')->name('afterPaymentByLinkCron');

Route::post('/ccpay', 'APIController@ccpay')->name('ccpay');

Route::post('/ccPaymentResponce', 'APIController@ccPaymentResponce')->name('ccPaymentResponce');
Route::post('/ccPaymentCancelResponce', 'APIController@ccPaymentCancelResponce')->name('ccPaymentCancelResponce');

Route::get('/itemListLayoutAjax', 'APIController@itemListLayoutAjax')->name('itemListLayoutAjax');

Route::get('/itemMasterLayoutAjax', 'APIController@itemMasterLayoutAjax')->name('itemMasterLayoutAjax');
