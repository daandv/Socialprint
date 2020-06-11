<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printer;
use App\UserAddressInfo;

use App\Rules\ValidPricePerPage;

class AccountCompleteController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
      // Check if user completed account
      if (Auth::user()->account_completed) {
        return redirect()->route('home');
      }
      return view('accounttype');
    }

    public function notAPrinter()
    {
      // Check if user completed account
      if (Auth::user()->account_completed) {
        return redirect()->route('home');
      }

      // Make user account status 'complete'
      $user = User::find(Auth::user()->id);
      $user->account_completed = 1;
      $user->save();

      notify()->success('Je kan nu beschikbare printers zoeken en bij hen afdrukken.', 'Fantastisch!');
      return redirect()->route('home');
    }

    public function addPrinter()
    {
      // Check if user completed account (for direct url)
      if (Auth::user()->account_completed) {
        return redirect()->route('home');
      }

      // Return view for adding printer
      return view('printercomplete');
    }

    public function addPrinterStore(Request $request) {
      $rules = [
        'address' => 'required',
        'busNumber' => 'nullable|numeric',
        'lat' => 'required',
        'lng' => 'required',
        'pp' => ['required', new ValidPricePerPage]
      ];
      $customMessages = [
        'address.required' => 'Geef een geldig adres.',
        'busNumber.numeric' => 'Geef een geldig busnummer.',
        'pp.required' => 'Geef je prijs per pagina.',
        'lat.required' => 'Geef een geldig adres.',
        'lng.required' => 'Geef een geldig adres.',
      ];
      $this->validate($request, $rules, $customMessages);


      // Fill in address info
      $useraddressinfo = new UserAddressInfo();
      $useraddressinfo->street_and_number = $request->address;
      $useraddressinfo->city = $request->city;
      $useraddressinfo->bus_number = $request->busNumber;
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

      notify()->success('Mensen kunnen je printer nu vinden op de kaart, bekijk binnenkomende printopdrachten bij "afdruktaken".', 'Fantastisch!');
      return redirect()->route('home');
    }

}
