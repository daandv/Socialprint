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
})->name('welcome');

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/changetoprinter', 'UserController@changeToPrinter')->name('changetoprinter');
Route::post('/changetoprinterstore', 'UserController@changeToPrinterStore')->name('changetoprinterstore');

Route::get('/profile/{userid}', 'ProfileController@index')->name('profile');
Route::get('/favorites', 'ProfileController@showfavorites')->name('favorites');
Route::get('/star/{userid}', 'ProfileController@star')->name('user.star');
Route::get('/unstar/{userid}', 'ProfileController@unstar')->name('user.unstar');

Route::get('/print_at/{id}', 'PrintController@index')->name('printat');
Route::post('/upload_at/{id}', 'PrintController@uploadFiles')->name('upload');

Route::get('/getfile/{fileName}', 'PrintController@getFile')->name('getfile');

Route::get('/printjobs', 'PrintJobController@index')->name('printjobs');
Route::get('/printjob/{id}', 'PrintJobController@showDetails')->name('printjob.details');
Route::get('/rejectprintjob/{id}', 'PrintJobController@reject')->name('printjob.reject');
Route::get('/acceptprintjob/{id}', 'PrintJobController@accept')->name('printjob.accept');
Route::get('/markdoneprintjob/{id}', 'PrintJobController@markDone')->name('printjob.done');

Route::post('/sendchat/{printjobid}', 'ChatController@send')->name('chat.send');

//SMALL API
Route::get('/printers', 'Api\PrinterController@index');




Route::get('/faq', function () {
  return view("staticpages.faq");
})->name('faq');
Route::get('/info', function () {
  return view("staticpages.infojurytesters");
})->name('info');
Route::get('/privacy', function () {
  return view("staticpages.privacy");
})->name('privacy');
