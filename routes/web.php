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
Route::get('/editaccount', 'UserController@reRouteShow')->name('editaccount'); //+
Route::get('/showprinter', 'UserController@showPrinter')->name('showprinter'); //+
Route::get('/shownonprinter', 'UserController@showNonPrinter')->name('shownonprinter'); //+
Route::get('/notavailable', 'UserController@removeAvailability'); //+
Route::get('/setavailable', 'UserController@addAvailability'); //+
Route::get('/changetoprinter', 'UserController@changeToPrinter');
Route::get('/profile/{id}', 'ProfileController@index');



Route::get('/complete', 'AccountCompleteController@index')->name('complete'); //+
Route::get('/notaprinter', 'AccountCompleteController@notaprinter')->name('notaprinter'); //+
Route::get('/addprinter', 'AccountCompleteController@addprinter')->name('addprinter'); //+


Route::post('/adduserprinter', 'UserController@complete');
Route::post('/changetoprinterupdate', 'UserController@changeToPrinterUpdate')->name('changetoprinterupdate');
// For error when getting to post method
// Route::get('/adduserprinter', function () {
//   return "dit gaat niet";
// });

Route::post('/account/update', 'UserController@update'); // For form


Route::get('/print_at/{id}', 'PrintController@index');
Route::post('/print_at/uploadprintjob', 'PrintController@uploadFiles');
Route::get('/getfile/{fileName}', 'PrintController@getFile')->name('getfile');

//SMALL API
Route::get('/printers', 'Api\PrinterController@index');
