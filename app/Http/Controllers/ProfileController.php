<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printer;
use App\UserAddressInfo;
use App\Favourite;

use Route;

class ProfileController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }
    public function index() {
      $userThatPrintsId = Route::current()->parameter('userid');
      $user = User::find(Auth::user()->id);

      // Check for route
      if (!User::find($userThatPrintsId)) {
        notify()->error('Profiel niet gevonden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if user has printer
      if (Printer::where('user_id', User::find($userThatPrintsId)->id)->count()==0) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      $userThatPrints = User::find($userThatPrintsId);
      $userThatPrintsAddressInfo = UserAddressInfo::find($userThatPrints->address_id);

      $favourited = Favourite::where('user_id', $user->id)->where('printer_user_id', $userThatPrints->id)->where('unfavourite', 0)->count();

      return view('profile', [
        'userThatPrints' => $userThatPrints,
        'userThatPrintsAddressInfo' => $userThatPrintsAddressInfo,
        'favourited' => $favourited,
      ]);
    }

    public function star() {
      $userThatPrintsId = Route::current()->parameter('userid');
      $user = User::find(Auth::user()->id);

      // Check for route
      if (!User::find($userThatPrintsId)) {
        notify()->error('Profiel niet gevonden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if user has printer
      if (Printer::where('user_id', User::find($userThatPrintsId)->id)->count()==0) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if printer available
      if (User::find($userThatPrintsId)->available==0) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if not itself
      if ($userThatPrintsId==$user->id) {
        notify()->error('Je kan jezelf niet toevoegen aan je favorieten.', 'Error!');
        return redirect()->route('home');
      }

      $exists = Favourite::where('user_id', $user->id)->where('printer_user_id', $userThatPrintsId);
      if ($exists->count()==1) {
        $favourite = Favourite::find($exists->first()->id);
        $favourite->unfavourite = 0;
        $favourite->save();
      } else {
        $favourite = new Favourite();
        $favourite->user_id = $user->id;
        $favourite->printer_user_id = $userThatPrintsId;
        $favourite->unfavourite = 0;
        $favourite->save();
      }
      return redirect()->route('profile', [$userThatPrintsId]);

    }



    public function unstar() {
      $userThatPrintsId = Route::current()->parameter('userid');
      $user = User::find(Auth::user()->id);

      // Check for route
      if (!User::find($userThatPrintsId)) {
        notify()->error('Profiel niet gevonden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if user has printer
      if (Printer::where('user_id', User::find($userThatPrintsId)->id)->count()==0) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if printer available
      if (User::find($userThatPrintsId)->available==0) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      // Check if not itself
      if ($userThatPrintsId==$user->id) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }

      $exists = Favourite::where('user_id', $user->id)->where('printer_user_id', $userThatPrintsId)->first();
      if ($exists) {
        $favourite = Favourite::where('user_id', $user->id)->where('printer_user_id', $userThatPrintsId)->first();
        $favourite->unfavourite = 1;
        $favourite->save();
        return redirect()->route('profile', [$userThatPrintsId]);
      }
      notify()->error('Er is een fout opgetreden.', 'Error!');
      return redirect()->route('home');


    }
}
