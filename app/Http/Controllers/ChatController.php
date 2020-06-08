<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Printjob;
use App\Printer;
use App\ChatMessage;

use Route;


class ChatController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }
    public function send(Request $request) {

      // Check for valid url
      $printjob = Printjob::find(Route::current()->parameter('printjobid'));
      $user = User::find(Auth::user()->id);

      if ($printjob) {
        // Check if user is authenticated
        $printer = Printer::find($printjob->printer_id);
        $userThatPrints = User::find($printer->user_id);

        if ($printjob->requester_id==$user->id) {
          // User is requester
          $chatMessage = new ChatMessage();
          $chatMessage->message = $request->message;
          $chatMessage->printjob_id = $printjob->id;
          $chatMessage->from_id = $user->id;
          $chatMessage->to_id = $userThatPrints->id;
          $chatMessage->save();
        } else if ($printjob->printer_id==Printer::where('user_id', $user->id)->first()->id) {
          // User is printer
          $chatMessage = new ChatMessage();
          $chatMessage->message = $request->message;
          $chatMessage->printjob_id = $printjob->id;
          $chatMessage->from_id = $user->id;
          $chatMessage->to_id = $printjob->requester_id;
          $chatMessage->save();
        }
      } else {
        // Printjob not found
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }





    }
}
