<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AnthonyMartin\GeoLocation\GeoPoint;
use App\User;
use App\Printer;
use App\UserAddressInfo;

class UserPrinterController extends Controller
{
    public function complete(Request $request)
    {
      $validatedData = $request->validate([
          'lat' => 'required',
          'lng' => 'required',
          'pp' => 'required'

      ]);

      // Fill in address info
      $useraddressinfo = new UserAddressInfo();
      $useraddressinfo->street_and_number = $request->address;
      $useraddressinfo->city = $request->city;
      $useraddressinfo->zip = $request->zip;
      $useraddressinfo->lat = $request->lat;
      $useraddressinfo->lng = $request->lng;
      $useraddressinfo->save();

      // Make user account status 'complete' and set 'available'
      $user = User::find(Auth::user()->id);
      $user->account_completed = 1;
      $user->available = 1;
      $user->address_id=$useraddressinfo->id;
      $user->save();

      // Add new printer
      $printer = new Printer();
      $printer->user_id = $user->id;
      $printer->price = $request->pp;

      switch ($request->printColor) {
        case 'bw':
          $printer->color_id = 2;
          // Only A4 for the moment (futureproof)
          $printer->format_id = 1;
          break;
        case 'color':
          $printer->color_id = 1;
          // Only A4 for the moment (futureproof)
          $printer->format_id = 1;
          break;
      }

      $printer->save();

      return redirect()->route('home')->with('status', "Profiel in orde");

    }
}
