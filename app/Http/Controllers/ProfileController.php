<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Route;

class ProfileController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }
    public function index() {
      $userThatPrintsId = Route::current()->parameter('id');
      return $userThatPrintsId;
    }
}
