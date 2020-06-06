<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printjob;
use App\Printer;

class PrintjobController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }

    public function index() {
      $user = User::find(Auth::user()->id);
      $printJobs = Printjob::where('requester_id', $user->id)->orWhere('printer_id', $user->id)->orderBy('created_at','desc')->get();


      $fullPrintJobInfo = [];
      foreach ($printJobs as $printJob) {
        $printerName = User::find($printJob->printer_id)->name;
        $requesterName = User::find($printJob->requester_id)->name;
        $printerDevice = Printer::where('user_id', $printJob->printer_id)->get();

        $fullPrintJobInfo[] = [
          'id' => $printJob->id,
          'printer_id' => $printJob->printer_id,
          'printer_name' => $printerName,
          'requester_id' => $printJob->requester_id,
          'requester_name' => $requesterName,
          'date' => $printJob->created_at->toDateString(),
          'printer' => $printerDevice,
        ];
      }

      return $fullPrintJobInfo;
      // return view('printjobs', [
      //   'printJobs' => $printJobs,
      //   'userId' => $userId->id,
      //   ''
      // ]);
    }
}
