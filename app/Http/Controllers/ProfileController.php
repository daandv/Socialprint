<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printer;
use App\UserAddressInfo;
use App\Favourite;
use App\Printjob;

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
      $printer = Printer::where('user_id', $userThatPrints->id)->first();
      $favourited = Favourite::where('user_id', $user->id)->where('printer_user_id', $userThatPrints->id)->where('unfavourite', 0)->count();

      // Printer reputation
      $reputation = 0;
      $profileMadeDate = strtotime($userThatPrints->created_at);
      $today = strtotime(date('Y-m-d H:i:s'));
      $daysActive = abs($today - $profileMadeDate);
      $years = floor($daysActive / (365*60*60*24));
      $months = floor(($daysActive - $years * 365*60*60*24)
                                     / (30*60*60*24));
      $daysActiveDays = floor(($daysActive - $years * 365*60*60*24 -
                   $months*30*60*60*24)/ (60*60*24));


      $printJobs = Printjob::where('printer_id', $printer->id)->get();
      $doneJobs = Printjob::where('printer_id', $printer->id)->where('status', "Klaar")->count();
      $notDoneJobs = Printjob::where('printer_id', $printer->id)->where('status', '!=', "Klaar")->count();

      if ($daysActiveDays<14) {
        $reputation = 1;
      } elseif ($printJobs->count()>50 && $doneJobs>$notDoneJobs) {
        $reputation = 2;
      }

      return view('profile', [
        'userThatPrints' => $userThatPrints,
        'userThatPrintsAddressInfo' => $userThatPrintsAddressInfo,
        'favourited' => $favourited,
        'reputation' => $reputation,
        'printer' => $printer,
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
      return redirect()->route('favorites');

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
        return redirect()->route('favorites');
      }

      notify()->error('Er is een fout opgetreden.', 'Error!');
      return redirect()->route('home');


    }

    public function showFavorites() {
      $user = User::find(Auth::user()->id);
      $favorites = Favourite::where('user_id', $user->id)
                            ->where('unfavourite', '0')
                            ->get();

      $fullFavoriteInfo = [];
      foreach ($favorites as $favorite) {
        $printer = User::find($favorite->printer_user_id);
        $fullAddress = UserAddressInfo::find($printer->address_id);

        $fullFavoriteInfo_ = [
          'fullUserInfo' => User::find($favorite->printer_user_id),
          'fullAddress' => $fullAddress,
          'fullPrinter' => Printer::where('user_id', $favorite->printer_user_id)->first(),
        ];
        array_push($fullFavoriteInfo, $fullFavoriteInfo_);
      }

      return view('favorites', ['favorites' => $fullFavoriteInfo]);
    }


}
