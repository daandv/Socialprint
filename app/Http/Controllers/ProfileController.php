<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Printer;
use App\UserAddressInfo;

use Route;

class ProfileController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }
    public function index() {
      $printerId = Route::current()->parameter('id');

      // Check for route
      if (!User::find(Printer::find($printerId))) {
        notify()->error('Profiel niet gevonden.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrints = User::find(Printer::find($printerId)->user_id);
      $userThatPrintsAddressInfo = UserAddressInfo::find($userThatPrints->address_id);

      return view('profile', [
        'userThatPrints' => $userThatPrints,
        'userThatPrintsAddressInfo' => $userThatPrintsAddressInfo,
      ]);
    }

    public function star() {
      return "star";
    }
    public function unstar() {
      return "unstar";
    }
}
