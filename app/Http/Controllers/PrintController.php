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
use App\Printjob;
use App\SharedFile;

class PrintController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }

    public function index() {
      $printer = Printer::find(Route::current()->parameter('id'));
      $requesterId = Auth::user()->id;

      // Check for valid url
      if (!$printer) {
        notify()->error('Deze printer is niet beschikbaar.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrintsId = User::find($printer->user_id)->id;
      // Check if not own id
      if ($userThatPrintsId==$requesterId) {
        notify()->error('Bij jezelf afdrukken gaat niet.', 'Error!');
        return redirect()->route('home');
      }

      // Check if available
      if (User::find($userThatPrintsId)->available==0) {
        notify()->error('Deze printer is niet beschikbaar.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrintsName = User::find($userThatPrintsId)->name;
      $requesterName = User::find($requesterId)->name;
      // $printer = Printer::where('user_id', $userThatPrintsId)->first();
      $pp = $printer->price;

      return view('fileupload', [
        'userThatPrintsId' => $userThatPrintsId,
        'userThatPrintsName' => $userThatPrintsName,
        'printerId' => $printer->id,
        'requesterId' => $requesterId,
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

      $printer = Printer::find(Route::current()->parameter('id'));
      $requesterId = Auth::user()->id;

      // Check for valid url
      if (!$printer) {
        notify()->error('Deze printer is niet beschikbaar.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrintsId = User::find($printer->user_id)->id;
      // Check if not own id
      if ($userThatPrintsId==$requesterId) {
        notify()->error('Bij jezelf afdrukken gaat niet.', 'Error!');
        return redirect()->route('home');
      }

      // Check if available
      if (User::find($userThatPrintsId)->available==0) {
        notify()->error('Deze printer is niet beschikbaar.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrintsName = User::find($userThatPrintsId)->name;
      $requesterName = User::find($requesterId)->name;


      if ($request->hasFile('file')) {
        $pageCounter=0;
        $pageCounterList = [];
        $fileList = [];

        foreach ($request->file as $file) {
          $key = Str::random(32);
          $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_". $key .".pdf";
          // $fileSize = $file->getSize();

          $file->storeAs('documents', $fileName, 's3');

          // Temporary url for counting pages
          $tempUrl = Storage::disk('s3')->temporaryUrl(
             'documents/' . $fileName, Carbon::now()->addMinutes(5)
          );

          $pdftext = file_get_contents($tempUrl);
          $num = preg_match_all("/\/Page\W/", $pdftext);
          $pageCounter += $num;

          array_push($pageCounterList, $num);

          $fileList[] = [
            'fileName' => $fileName,
            'pageCount' => $num,
          ];
        }
        if (in_array(0, $pageCounterList)) {
          notify()->error('Ongeldige file(s) aanwezig, kan printopdracht niet verwerken.', 'Error');
          return redirect()->route('home');
        } else {
          // Add new printjob to db
          $printjob = new Printjob;
          $printjob->printer_id = Route::current()->parameter('id');
          $printjob->requester_id = $requesterId;
          $printjob->status = "Aangevraagd";
          $printjob->notification_printer = 1;
          $printjob->save();

          foreach ($fileList as $file) {
            $file_ = new SharedFile;
            $file_->printjob_id = $printjob->id;
            $file_->file_name = $file['fileName'];
            $file_->page_count = $file['pageCount'];
            $file_->save();
          }
          notify()->success('File(s) geupload naar s3 en DB.', 'Joepie!');
          return redirect()->route('home');
        }

      }
      notify()->error('Er is een fout opgetreden.', 'Error!');
      return redirect()->route('home');
    }

    public function getFile()
    {
      // TO VALIDATE
      // Request $file
      try {
          return Storage::disk('s3')->response('documents/' . Route::current()->parameter('fileName'));
      } catch (\Exception $e) {
          return redirect()->route('home')->with('status', "Bestand niet gevonden");
      }


    }



}
