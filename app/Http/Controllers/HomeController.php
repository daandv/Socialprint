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
        // For flash messages
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (session('verified')) {
          return view('completedanimation');
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
