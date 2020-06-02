<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class PrintController extends Controller
{
    public function __construct()
    {
       //dit toevoegen aan controllers die beschermd moeten worden
        $this->middleware(['auth','verified']);
    }
    public function index() {
      $userThatPrintsId = Route::current()->parameter('id');
      return $userThatPrintsId;
    }
}
