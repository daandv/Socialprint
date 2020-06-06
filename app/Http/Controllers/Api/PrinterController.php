<?php

namespace App\Http\Controllers\Api; // Change folder to Api

use App\Http\Controllers\Controller; // Threating this file like a controller
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
      ->select('users.name', 'users.id', 'user_address_infos.lat', 'user_address_infos.lng', 'printers.id as printer_id', 'printers.price', 'printers.format_id', 'printers.color_id')
      ->get();


      // $printersInArray = json_decode(json_encode($printers), true);
      // return PrinterResource::collection($printersInArray);
      return new PrinterResource($printers);
    }
}
