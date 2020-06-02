<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

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

    public function notaprinter()
    {
      // Check if user completed account
      if (Auth::user()->account_completed) {
        return redirect()->route('home');
      }

      // Make user account status 'complete'
      $user = User::find(Auth::user()->id);
      $user->account_completed = 1;
      $user->save();

      return redirect()->route('home')->with('status', "profiel in orde");
    }

    public function addprinter()
    {
      // Check if user completed account (for direct url)
      if (Auth::user()->account_completed) {
        return redirect()->route('home');
      }

      // Return view for adding printer
      return view('accountcomplete');
    }

}
