<?php

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

Route::get('/', function () {
    return view('welcome');
    // return redirect()->route('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/map', 'MapController@index');
Route::get('/editaccount', 'UserController@show');
Route::get('/profile/{id}', 'ProfileController@index');

Route::get('/print_at/{id}', 'PrintController@index');
// Route::get('/complete', function () {
//     return view('accountcomplete');
// });
Route::get('/complete', 'AccountCompleteController@index')->name('complete');
Route::get('/notaprinter', 'AccountCompleteController@notaprinter')->name('notaprinter');
Route::get('/addprinter', 'AccountCompleteController@addprinter')->name('addprinter');

Route::post('/adduserprinter', 'UserController@complete');
// For error when getting to post method
// Route::get('/adduserprinter', function () {
//   return "dit gaat niet";
// });
Route::post('/account/update', 'UserController@update');

//SMALL API
Route::get('/printers', 'Api\PrinterController@index');
