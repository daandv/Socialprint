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
    // return view('welcome');
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/map', 'MapController@index')->name('map');
// Route::get('/complete', function () {
//     return view('accountcomplete');
// });
Route::get('/complete', 'AccountCompleteController@index')->name('complete');
Route::get('/notaprinter', 'AccountCompleteController@notaprinter')->name('notaprinter');
Route::get('/addprinter', 'AccountCompleteController@addprinter')->name('addprinter');

Route::post('/adduserprinter', 'UserPrinterController@complete');


//API
Route::get('/printers', 'PrinterController@index');
