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

Route::get('/complete', 'AccountCompleteController@index')->name('complete');
Route::get('/notaprinter', 'AccountCompleteController@notAPrinter')->name('notaprinter');
Route::get('/addprinter', 'AccountCompleteController@addPrinter')->name('addprinter');
Route::post('/adduserprinter', 'AccountCompleteController@addPrinterStore');

Route::get('/showprinter', 'UserController@showPrinter')->name('showprinter');
Route::get('/shownonprinter', 'UserController@showNonPrinter')->name('shownonprinter');
Route::get('/notavailable', 'UserController@removeAvailability');
Route::get('/setavailable', 'UserController@addAvailability');

Route::get('/editaccount', 'UserController@reRouteShow')->name('editaccount');
Route::post('/editaccount/update/printer', 'UserController@updatePrinterStore')->name('update.storeprinter'); // For form
Route::post('/editaccount/update/nonprinter', 'UserController@updateNonPrinterStore')->name('update.storenonprinter'); // For form

Route::get('/changetoprinter', 'UserController@changeToPrinter');
Route::post('/changetoprinterstore', 'UserController@changeToPrinterStore')->name('changetoprinterstore');
Route::get('/profile/{id}', 'ProfileController@index');


// For error when getting to post method
// Route::get('/adduserprinter', function () {
//   return "dit gaat niet";
// });

Route::get('/test', function () {
  return view("verified");
});




Route::get('/print_at/{id}', 'PrintController@index');
Route::post('/print_at/uploadprintjob', 'PrintController@uploadFiles');
Route::get('/getfile/{fileName}', 'PrintController@getFile')->name('getfile');

//SMALL API
Route::get('/printers', 'Api\PrinterController@index');
