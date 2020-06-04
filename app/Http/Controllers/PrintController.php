<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return redirect()->route('home')->with('status', "Deze printer is op dit moment helaas niet beschikbaar");
      }

      // Check if not own id
      if ($userThatPrintsId==$requesterId) {
        return redirect()->route('home')->with('status', "Bij jezelf afdrukken gaat niet ;)");
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
      if ($request->hasFile('file')) {
        // return $request->all();
        foreach ($request->file as $file) {
          $key = Str::random(32);
          $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_". $key .".pdf";
          $fileSize = $file->getSize();

          $file->storeAs('documents', $fileName, 's3');
        }



        // Add new printjob to db here
        return $fileSize;
      }

      // return "test";
      // return redirect()->route('home')->with('status', "Werkt");
    }



}
