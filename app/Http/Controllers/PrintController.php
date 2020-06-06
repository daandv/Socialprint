<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;

use Route;
use Str;


use App\User;
use App\Printer;

class PrintController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified']);
    }
    public function index() {
      $userThatPrintsId = Route::current()->parameter('id');
      $requesterId = Auth::user()->id;
      $exists = User::where('id', '=', $userThatPrintsId)->where('available', '=', 1)->first();

      // Check for valid url
      if (!$exists) {
        smilify('error', 'Deze printer is niet beschikbaar.');
        return redirect()->route('home');
      }

      // Check if not own id
      if ($userThatPrintsId==$requesterId) {
        smilify('error', 'Bij jezelf afdrukken gaat niet ;)');
        return redirect()->route('home');
      }

      $userThatPrintsName = User::find($userThatPrintsId)->name;
      $requesterName = User::find($requesterId)->name;
      $printer = Printer::where('user_id', $userThatPrintsId)->first();
      $pp = $printer->price;

      return view('fileupload', [
        'userThatPrintsId' => $userThatPrintsId,
        'requesterId' => $requesterId,
        'userThatPrintsName' => $userThatPrintsName,
        'requesterName' => $requesterName,
        'pp' => $pp,
      ]);
    }

    public function uploadFiles(Request $request)
    {

      $rules = [
        'file' => 'required',
        'file.*' => 'mimes:pdf|max:40000'
      ];
      $customMessages = [
        'max' => 'De maximum filegrootte is 40MB.',
        'required' => 'Geen file gevonden.',
        'mimes' => 'Enkel PDF bestanden toegelaten'
      ];
      $this->validate($request, $rules, $customMessages);

      if ($request->hasFile('file')) {
        $pageCounter=0;
        foreach ($request->file as $file) {
          $key = Str::random(32);
          $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_". $key .".pdf";
          $fileSize = $file->getSize();

          $file->storeAs('documents', $fileName, 's3');

          // Temporary url for counting pages
          $tempUrl = Storage::disk('s3')->temporaryUrl(
             'documents/' . $fileName, Carbon::now()->addMinutes(5)
          );

          $pdftext = file_get_contents($tempUrl);
          $num = preg_match_all("/\/Page\W/", $pdftext);
          $pageCounter += $num;
        }
        // return $pageCounter;


        // return redirect()->route('getfile', ['fileName' => $fileName]);

        // Add new printjob to db here
        // return $fileSize;

        return redirect()->route('home')->with('status', "File geupload naar Amazon S3 en in database verwerkt.");
      }

      // return "test";
      // return redirect()->route('home')->with('status', "Werkt");
    }

    public function getFile()
    {

      // Request $file
      try {
          return Storage::disk('s3')->response('documents/' . Route::current()->parameter('fileName'));
      } catch (\Exception $e) {
          return redirect()->route('home')->with('status', "Bestand niet gevonden");
      }


    }



}
