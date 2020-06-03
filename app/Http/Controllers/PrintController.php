<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Route;

use App\User;

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


      return view('fileupload', [
        'userThatPrintsId' => $userThatPrintsId,
        'requesterId' => $requesterId
      ]);

    }
}
