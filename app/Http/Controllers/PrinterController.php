<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Resources\Printer as PrinterResource;


use App\User;
use App\Printer;
use App\UserAddressInfo;


class PrinterController extends Controller
{
  public function __construct()
  {
     // Protected controller
      $this->middleware(['auth','verified']);
  }
  public function index() {
      // $printers = User::where('available', 1)->userAddressInfo;
      // $printers = User::find(1)->get();
      //normaal model in printers variabele steken
      $printers = DB::table('users')
      ->where('available','=',1)
      ->join('user_address_infos','users.address_id','=','user_address_infos.id')
      ->join('printers','users.id','=','printers.user_id')
      ->select('users.name', 'user_address_infos.lat', 'user_address_infos.lng', 'printers.price', 'printers.format_id', 'printers.color_id')
      ->get();

      $array = json_decode(json_encode($printers), true);

      // $printers = DB::table('users')
      //     ->select('user.name', 'user.id')
      //     ->join('user_address_infos','user.address_id','=','school_status.link_id')
      //     ->where('links.id','!=',35)
      //     ->where('school_status.academic_year','=','2014-15')
      //     ->get();
      return PrinterResource::collection($array);
    }
}
