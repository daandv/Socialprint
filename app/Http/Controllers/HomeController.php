<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Printjob;
use App\Printer;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (session('verified')) {
          return view('verified');
        }

        // Check if account is completed (not middleware because of mail animation)
        if (!Auth::user()->account_completed) {
          return redirect()->route('complete');
        }

        $user = Auth::user();

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
          return view('home', [
            'user' => $user,
          ]);
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

        return view('home', [
          'user' => $user,
        ]);



    }

}
