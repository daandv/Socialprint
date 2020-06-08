<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Printjob;
use App\Printer;
use App\User;
use App\ChatMessage;


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
        return view('home', [
          'user' => $user,
        ]);



    }

}
