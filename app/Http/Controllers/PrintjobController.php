<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printjob;
use App\Printer;

use Session;

class PrintJobController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }

    public function index() {
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // If user has printer
      if ($printer) {
        $userPrinter = Printer::where('user_id', $user->id)->first()->id;

        // Find all involved printjobs
        $printJobs = Printjob::where('requester_id', $user->id)
          ->orWhere('printer_id', $userPrinter)
          ->orderBy('created_at','desc')->get();

        $fullPrintJobInfo = [];
        foreach ($printJobs as $printJob) {
          $printer = Printer::find($printJob->printer_id);
          $printerPrice = $printer->price;

          $userThatPrintsId = User::find($printer->user_id)->id;
          $requesterId = $printJob->requester_id;

          $userThatPrintsName = User::find($printer->user_id)->name;
          $requesterName = User::find($printJob->requester_id)->name;

          // If user is requester en has notifications
          if ($printJob->requester_id==$user->id) {
              $printJob_ = Printjob::find($printJob->id);
              $printJob_->notification_requester = 0;
              $printJob_->save();
              Session::forget('notification');
          }
          // If user is printer en has notifications
          if ($userThatPrintsId==$user->id) {
              $printJob_ = Printjob::find($printJob->id);
              $printJob_->notification_printer = 0;
              $printJob_->save();
              Session::forget('notification');
          }

          $fullPrintJobInfo[] = [
            'id' => $printJob->id,
            'userThatPrintsName' => $userThatPrintsName,
            'userThatPrintsId' => $userThatPrintsId,
            'requesterId' => $requesterId,
            'requesterName' => $requesterName,
            'date' => $printJob->created_at->toDateString(),
            'printer' => $printer,
            'price' => $printerPrice
          ];
        }

        return view('printjobs', [
          'fullPrintJobInfo'=>$fullPrintJobInfo,
          'userId' => $user->id,
        ]);
      } else {
        // User has no printer

        // Find all involved printjobs
        $printJobs = Printjob::where('requester_id', $user->id)
          ->orderBy('created_at','desc')->get();

        $fullPrintJobInfo = [];
        foreach ($printJobs as $printJob) {
          $printer = Printer::find($printJob->printer_id);
          $printerPrice = $printer->price;

          $userThatPrintsId = User::find($printer->user_id)->id;
          $requesterId = $printJob->requester_id;

          $userThatPrintsName = User::find($printer->user_id)->name;
          $requesterName = User::find($printJob->requester_id)->name;


          $fullPrintJobInfo[] = [
            'id' => $printJob->id,
            'userThatPrintsName' => $userThatPrintsName,
            'userThatPrintsId' => $userThatPrintsId,
            'requesterId' => $requesterId,
            'requesterName' => $requesterName,
            'date' => $printJob->created_at->toDateString(),
            'printer' => $printer,
            'price' => $printerPrice
          ];
        }

        return view('printjobs', [
          'fullPrintJobInfo'=>$fullPrintJobInfo,
          'userId' => $user->id,
        ]);
      }


    }
}
