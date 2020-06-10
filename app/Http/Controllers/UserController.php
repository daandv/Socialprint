<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printer;
use App\UserAddressInfo;
use App\Printjob;

use App\Rules\ValidPricePerPage;

class UserController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }

    public function changeToPrinter() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // If user has printer
      if ($printer) {
        return redirect()->route('home')->with('status', "Foute route");
      }

      return view('changetoprinter');
    }

    public function changeToPrinterStore(Request $request) {

      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // User has printer
      if ($printer) {
        return redirect()->route('home')->with('status', "Foute route");
      }

      $rules = [
        'address' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'pp' => ['required', new ValidPricePerPage]
      ];
      $customMessages = [
        'address.required' => 'Geef een geldig adres.',
        'pp.required' => 'Geef je prijs per pagina.',
        'lat.required' => 'Geef een geldig adres.',
        'lng.required' => 'Geef een geldig adres.',
      ];
      $this->validate($request, $rules, $customMessages);

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
      notify()->success('Mensen kunnen je printer nu vinden op de kaart, bekijk binnenkomende printopdrachten bij "afdruktaken".', 'U bent nu een printer.');
      return redirect()->route('home');
    }

    public function reRouteShow() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // Check for notifications
      // If user has printer
      if ($printer) {
        $userPrinter = Printer::where('user_id', $user->id)->first()->id;

        $printJobs = Printjob::where('requester_id', $user->id)
                ->orWhere('printer_id', $userPrinter)
                ->orderBy('created_at','desc')->get();


        foreach ($printJobs as $printJob) {
          $printer = Printer::find($printJob->printer_id);
          $userThatPrintsId = User::find($printer->user_id)->id;

          // If user is requester en has notifications
          if ($printJob->requester_id==$user->id) {
            if ($printJob->notification_requester) {
              session(['notification' => 1]);
            }
          }

          // If user is printer en has notifications
          if ($userThatPrintsId==$user->id) {
            if ($printJob->notification_printer) {
              session(['notification' => 1]);
            }
          }
        }
        return redirect()->route('showprinter');
      } else {
        // User has no printer
        $printJobs = Printjob::where('requester_id', $user->id)
                // ->orWhere('printer_id', $userPrinter)
                ->orderBy('created_at','desc')->get();

        // If user is requester en has notifications
        foreach ($printJobs as $printJob) {
          if ($printJob->requester_id==$user->id) {
            if ($printJob->notification_requester) {
              session(['notification' => 1]);
            }
          }
        }
      }

      return redirect()->route('shownonprinter');








      // User has printer
      // if ($printer) {
      //   return redirect()->route('showprinter');
      // } else {
      //   return redirect()->route('shownonprinter');
      // }
    }

    public function showPrinter() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // User has no printer
      if (!$printer) {
          return redirect()->route('shownonprinter');
      }


      $address = UserAddressInfo::where('id',$user->address_id)->first();
      $printer = Printer::where('user_id',$user->id)->first();

      $name = $user->name;
      $fullAddress = $address->street_and_number;
      $lat = $address->lat;
      $lng = $address->lng;
      $city = $address->city;
      $colorId = $printer->color_id;
      $pp = $printer->price;
      $zip = $address->zip;
      $availability = $user->available;
      $emailNotif = $user->email_notifications;

      return view('accountprinter', [
        'name' => $name,
        'address' => $fullAddress,
        'city' => $city,
        'colorId' => $colorId,
        'pp' => $pp,
        'lat' => $lat,
        'lng' => $lng,
        'zip' => $zip,
        'available' => $availability,
        'emailNotif' => $emailNotif,
      ]);
    }

    public function showNonPrinter() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // User is a printer
      if ($printer) {
          return redirect()->route('showprinter');
      }

      $name = $user->name;
      $emailNotif = $user->email_notifications;

      return view('accountnonprinter', [
        'name' => $name,
        'emailNotif' => $emailNotif,
      ]);
    }

    public function removeAvailability() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // User has no printer
      if (!$printer) {
          notify()->error('Dit is een foute route.', 'Error!');
          return redirect()->route('home');
      }


      $user->available=0;
      $user->save();
      notify()->success('Je bent nu niet meer zichtbaar op de kaart. Je kan dit terug aanzetten in uw profiel.', 'In orde!');
      return redirect()->route('home');
    }

    public function addAvailability() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // User has no printer
      if (!$printer) {
          notify()->error('Dit is een foute route.', 'Error!');
          return redirect()->route('home');
      }

      $user->available=1;
      $user->save();
      notify()->success('Je bent weer zichtbaar op de kaart en beschikbaar om te printen.', 'Fantastisch!');
      return redirect()->route('home');
    }

    public function updatePrinterStore(Request $request) {
      $rules = [
        'address' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'pp' => ['required', new ValidPricePerPage]
      ];
      $customMessages = [
        'address.required' => 'Geef een geldig adres.',
        'pp.required' => 'Geef je prijs per pagina.',
        'lat.required' => 'Geef een geldig adres.',
        'lng.required' => 'Geef een geldig adres.',
      ];
      $this->validate($request, $rules, $customMessages);

      $user = User::find(Auth::user()->id);
      $user->name = $request->name;

      if ($request->mailNotif==1) {
        $user->email_notifications=1;
      } else {
        $user->email_notifications=0;
      }

      $user->save();

      $useraddressinfo = UserAddressInfo::find($user->address_id);
      $useraddressinfo->street_and_number = $request->address;
      $useraddressinfo->city = $request->city;
      $useraddressinfo->zip = $request->zip;
      $useraddressinfo->lat = $request->lat;
      $useraddressinfo->lng = $request->lng;
      $useraddressinfo->save();

      // Update printer
      $printer = Printer::where('user_id', $user->id)->first();
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

      notify()->success('Profiel geüpdatet', 'Opgeslagen!');
      return redirect()->route('home');
    }

    public function updateNonPrinterStore(Request $request) {
      $rules = [
        'name' => 'required|max:50',
      ];
      $customMessages = [
        'required' => 'Deze naam is niet geldig.',
        'max' => 'Naam maximum 50 tekens.'
      ];
      $this->validate($request, $rules, $customMessages);

      $user = User::find(Auth::user()->id);
      $user->name = $request->name;

      if ($request->mailNotif==1) {
        $user->email_notifications=1;
      } else {
        $user->email_notifications=0;
      }


      $user->save();

      notify()->success('Profiel geüpdatet', 'Opgeslagen!');
      return redirect()->route('home');
    }


}
