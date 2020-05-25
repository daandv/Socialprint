<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function __construct()
    {
       //dit toevoegen aan controllers die beschermd moeten worden
        $this->middleware(['auth','verified']);
    }
    public function index()
    {
        return view('map');
    }
}
