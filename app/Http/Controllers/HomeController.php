<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Check if account is completed:
        if (!Auth::user()->account_completed) {
          return redirect()->route('complete');
        }

        // Anders:
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function verifiedMessage() {
      smilify('success', 'Je email is gevalideerd.');
      return redirect()->route('home');
    }
}
