<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Printer;
use App\Printjob;
use App\ChatMessage;
use App\User;

class LoadNotificationsHelper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (Auth::user()) {
        $user = Auth::user();
        $printer = Printer::where('user_id',$user->id)->first();

        // Check for new printjob
        // If user has printer
        if ($printer) {
          $userPrinter = Printer::where('user_id', $user->id)->first()->id;
          $printJobs = Printjob::where('requester_id', $user->id)
                  ->orWhere('printer_id', $userPrinter)
                  ->orderBy('created_at','desc')->get();
          foreach ($printJobs as $printJob) {
            $printer = Printer::find($printJob->printer_id);
            $userThatPrintsId = User::find($printer->user_id)->id;
            // If user is requester en has notifications
            if ($printJob->requester_id==$user->id) {
              if ($printJob->notification_requester) {
                session(['notificationPrintjob' => 1]);
              }
            }
            // If user is printer en has notifications
            if ($userThatPrintsId==$user->id) {
              if ($printJob->notification_printer) {
                session(['notificationPrintjob' => 1]);
              }
            }
          }
        } else {
          // User has no printer
          $printJobs = Printjob::where('requester_id', $user->id)
                  ->orderBy('created_at','desc')->get();
          // If user is requester en has notifications
          foreach ($printJobs as $printJob) {
            if ($printJob->requester_id==$user->id) {
              if ($printJob->notification_requester) {
                session(['notificationPrintjob' => 1]);
              }
            }
          }
        }

        // Check for unread messages
        $unreadMessages = ChatMessage::where('to_id', $user->id)
                ->where('read', '0')
                ->count();
        if ($unreadMessages>0) {
          session(['notificationMessage' => 1]);
        }
      }
      return $next($request);
    }
}
