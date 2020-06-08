<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\User;
use App\Printjob;
use App\Printer;
use App\SharedFile;
use App\UserAddressInfo;
use App\ChatMessage;

use Session;
use Route;


class PrintJobController extends Controller
{
    public function __construct()
    {
       // Protected controller
        $this->middleware(['auth','verified', 'completed']);
    }

    public function index(Request $request) {
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

          // Clear notifications
          // If user is requester en has notifications
          if ($printJob->requester_id==$user->id) {
              $printJob_ = Printjob::find($printJob->id);
              $printJob_->notification_requester = 0;
              $printJob_->save();
              Session::forget('notificationPrintjob');
          }
          // If user is printer en has notifications
          if ($userThatPrintsId==$user->id) {
              $printJob_ = Printjob::find($printJob->id);
              $printJob_->notification_printer = 0;
              $printJob_->save();
              Session::forget('notificationPrintjob');
          }

          // Check for messages
          $unreadMessages = ChatMessage::where('to_id', $user->id)
                  ->where('read', '0')
                  ->where('printjob_id', $printJob->id)
                  ->count();


          $fullPrintJobInfo_ = [
            'id' => $printJob->id,
            'userThatPrintsName' => $userThatPrintsName,
            'userThatPrintsId' => $userThatPrintsId,
            'requesterId' => $requesterId,
            'requesterName' => $requesterName,
            'date' => $printJob->created_at->toDateString(),
            'printer' => $printer,
            'price' => $printerPrice,
            'status' => $printJob->status,
            'unreadMessages' => $unreadMessages,
          ];
          array_push($fullPrintJobInfo, $fullPrintJobInfo_);

        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($fullPrintJobInfo);

        // Define how many items we want to be visible in each page
        $perPage = 5;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generated links
        $paginatedItems->setPath($request->url());

        return view('printjobs', [
          'fullPrintJobInfo'=>$paginatedItems,
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

          //Clear notifications
          if ($printJob->requester_id==$user->id) {
              $printJob_ = Printjob::find($printJob->id);
              $printJob_->notification_requester = 0;
              $printJob_->save();
              Session::forget('notification');
          }

          // Check for messages
          $unreadMessages = ChatMessage::where('to_id', $user->id)
                  ->where('read', '0')
                  ->where('printjob_id', $printJob->id)
                  ->count();

          $fullPrintJobInfo_ = [
            'id' => $printJob->id,
            'userThatPrintsName' => $userThatPrintsName,
            'userThatPrintsId' => $userThatPrintsId,
            'requesterId' => $requesterId,
            'requesterName' => $requesterName,
            'date' => $printJob->created_at->toDateString(),
            'printer' => $printer,
            'price' => $printerPrice,
            'status' => $printJob->status,
            'unreadMessages' => $unreadMessages,
          ];
          array_push($fullPrintJobInfo, $fullPrintJobInfo_);

        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($fullPrintJobInfo);

        // Define how many items we want to be visible in each page
        $perPage = 5;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generated links
        $paginatedItems->setPath($request->url());

        return view('printjobs', [
          'fullPrintJobInfo'=>$paginatedItems,
          'userId' => $user->id,
        ]);
      }
    }

    public function showDetails() {
      $printJobId = Route::current()->parameter('id');

      if (!Printjob::find($printJobId)) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();


      //Mark messages read
      $unreadMessages = ChatMessage::where('to_id', $user->id)
              ->where('printjob_id', $printJobId)
              ->where('read', '0')->get();
      Session::forget('notificationMessage');

      foreach ($unreadMessages as $message) {
        $message_ = ChatMessage::find($message->id);
        $message_->read = 1;
        $message_->save();
      }

      // Check if user has rights to printjob
      // If user has printer
      if ($printer) {
        $printerId = Printer::where('user_id', $user->id)->first()->id;
        // User is user that prints
        if (Printjob::find($printJobId)->printer_id==$printerId) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printJob = Printjob::find($printJobId);

          $printer = Printer::find($printJob->printer_id);
          $userThatPrints = User::find($printer->user_id);
          $userThatPrintsName = $userThatPrints->name;
          $userAddressDetails = UserAddressInfo::find($userThatPrints->address_id);

          $requester = User::find($printJob->requester_id);
          $requesterName = $requester->name;

          $pricePp = Printer::find($printerId)->price;
          $totalPages = SharedFile::where('printjob_id', $printJobId)->sum('page_count');
          $totalPrice = $pricePp * $totalPages;

          // Get messages
          $fullMessagesInfo = [];

          $messages = ChatMessage::where('printjob_id', $printJobId)->orderBy('created_at','desc')->limit(500)->get()->reverse();

          foreach ($messages as $message) {
            $fullMessagesInfo_ = [
              'fromName' => User::find($message->from_id)->name,
              'fromId' => User::find($message->from_id)->id,
              'message' => $message->message,
              'date' => $message->created_at,
            ];
            array_push($fullMessagesInfo, $fullMessagesInfo_);
          }

          return view('printjobdetails', [
            'isPrinter'=>1,
            'fileNames'=>$files,
            'printJobId'=>$printJobId,
            'totalPages' => $totalPages,
            'pricePp' => $pricePp,
            'totalPrice' => $totalPrice,
            'userThatPrintsName' => $userThatPrintsName,
            'userAddressDetails' => $userAddressDetails,
            'requesterName' => $requesterName,
            'messages' => $fullMessagesInfo,
            'currentUserId' => $user->id,
          ]);
        }
        // User is requester
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printJob = Printjob::find($printJobId);

          $printer = Printer::find($printJob->printer_id);
          $userThatPrints = User::find($printer->user_id);
          $userThatPrintsName = $userThatPrints->name;
          $userAddressDetails = UserAddressInfo::find($userThatPrints->address_id);

          $pricePp = Printer::find($printerId)->price;
          $totalPages = SharedFile::where('printjob_id', $printJobId)->sum('page_count');
          $totalPrice = $pricePp * $totalPages;

          // Get messages
          $fullMessagesInfo = [];

          $messages = ChatMessage::where('printjob_id', $printJobId)->orderBy('created_at','desc')->limit(500)->get()->reverse();

          foreach ($messages as $message) {
            $fullMessagesInfo_ = [
              'fromName' => User::find($message->from_id)->name,
              'fromId' => User::find($message->from_id)->id,
              'message' => $message->message,
              'date' => $message->created_at,
            ];
            array_push($fullMessagesInfo, $fullMessagesInfo_);
          }


          return view('printjobdetails', [
            'isPrinter'=>0,
            'fileNames'=>$files,
            'printJobId'=>$printJobId,
            'totalPages' => $totalPages,
            'pricePp' => $pricePp,
            'totalPrice' => $totalPrice,
            'userThatPrintsName' => $userThatPrintsName,
            'userAddressDetails' => $userAddressDetails,
            'messages' => $fullMessagesInfo,
            'currentUserId' => $user->id,
          ]);
        }
      } else {
        // User is requester;
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printJob = Printjob::find($printJobId);

          $printer = Printer::find($printJob->printer_id);
          $userThatPrints = User::find($printer->user_id);
          $userThatPrintsName = $userThatPrints->name;
          $userAddressDetails = UserAddressInfo::find($userThatPrints->address_id);

          $pricePp = $printer->price;
          $totalPages = SharedFile::where('printjob_id', $printJobId)->sum('page_count');
          $totalPrice = $pricePp * $totalPages;

          // Get messages
          $fullMessagesInfo = [];

          $messages = ChatMessage::where('printjob_id', $printJobId)->orderBy('created_at','desc')->limit(500)->get()->reverse();

          foreach ($messages as $message) {
            $fullMessagesInfo_ = [
              'fromName' => User::find($message->from_id)->name,
              'fromId' => User::find($message->from_id)->id,
              'message' => $message->message,
              'date' => $message->created_at,
            ];
            array_push($fullMessagesInfo, $fullMessagesInfo_);
          }


          return view('printjobdetails', [
            'isPrinter'=>0,
            'fileNames'=>$files,
            'printJobId'=>$printJobId,
            'totalPages' => $totalPages,
            'pricePp' => $pricePp,
            'totalPrice' => $totalPrice,
            'userThatPrintsName' => $userThatPrintsName,
            'userAddressDetails' => $userAddressDetails,
            'messages' => $fullMessagesInfo,
            'currentUserId' => $user->id,
          ]);
        }
      }
    }

    public function reject() {
      $printJobId = Route::current()->parameter('id');

      if (!Printjob::find($printJobId)) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // Check if user has rights to printjob
      // If user has printer
      if ($printer) {
        $userPrinter = Printer::where('user_id', $user->id)->first()->id;
        // User is user that prints
        if (Printjob::find($printJobId)->printer_id==$userPrinter) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printjob = Printjob::find($printJobId);
          $printjob->status = "Geweigerd";
          $printjob->notification_requester=1;
          $printjob->save();
          notify()->info('De aanvrager ontvangt een melding dat je niet zal afprinten.', 'Jammer.');
          return redirect()->route('home');
        }
        // User is requester
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      } else {
        // User is requester;
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      }
    }

    public function accept() {
      $printJobId = Route::current()->parameter('id');

      if (!Printjob::find($printJobId)) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // Check if user has rights to printjob
      // If user has printer
      if ($printer) {
        $userPrinter = Printer::where('user_id', $user->id)->first()->id;
        // User is user that prints
        if (Printjob::find($printJobId)->printer_id==$userPrinter) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printjob = Printjob::find($printJobId);
          $printjob->status = "Geaccepteerd";
          $printjob->notification_requester=1;
          $printjob->save();
          notify()->success('De aanvrager ontvangt een melding dat je zal afprinten.', 'Leuk!');
          return redirect()->route('home');
        }
        // User is requester
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      } else {
        // User is requester;
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      }
    }

    public function markDone() {
      $printJobId = Route::current()->parameter('id');

      if (!Printjob::find($printJobId)) {
        notify()->error('Er is een fout opgetreden.', 'Error!');
        return redirect()->route('home');
      }
      $user = User::find(Auth::user()->id);
      $printer = Printer::where('user_id',$user->id)->first();

      // Check if user has rights to printjob
      // If user has printer
      if ($printer) {
        $userPrinter = Printer::where('user_id', $user->id)->first()->id;
        // User is user that prints
        if (Printjob::find($printJobId)->printer_id==$userPrinter) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          $printjob = Printjob::find($printJobId);
          $printjob->status = "Klaar";
          $printjob->notification_requester=1;
          $printjob->save();
          notify()->success('De aanvrager ontvangt een melding dat de print klaarligt.', 'Fantastisch!');
          return redirect()->route('home');
        }
        // User is requester
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      } else {
        // User is requester;
        if (Printjob::find($printJobId)->requester_id==$user->id) {
          $files = SharedFile::where('printjob_id', $printJobId)->get();
          notify()->error('Er is een fout opgetreden.', 'Error!');
          return redirect()->route('home');
        }
      }
    }



}
