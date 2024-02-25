<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Ticket;
use App\TicketMessages;
use App\User;
use App\Admin;
use App\Http\Controllers\LogController;

class TicketController extends Controller
{
    public static function viewAll(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $tickets = Ticket::all();

        foreach ($tickets as $ticket){
            $ticket->username = User::where('uid', $ticket->uid)->first()->username;

            $messages = TicketMessages::where('tid', $ticket->tid)->get();
            $lastMessage = $messages[count($messages)-1];

            if ($lastMessage->aid == 0){
                $ticket->status = 0;
            }

            if ($lastMessage->uid == 0){
                $ticket->status = 1;
            }

            if ($ticket->is_closed == 1){
                $ticket->status = 2;
            }
        }

        return view('pages.tickets.all', ['tickets' => $tickets]);
    }

    public static function delete(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        if ($ticket == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found'
            ]);
        }

        LogController::writeLog($admin->username . " (" . $admin->aid . ") Deleted ticket with id: " . $ticket->tid);

        $ticket->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Deleted ticket'
        ]);
    }

    public static function detail(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        $user = User::where('uid', $ticket->uid)->first();
        if ($ticket == null){
            return redirect('/panel/home');
        }

        $ticketMessages = TicketMessages::where('tid', $ticket->tid)->get();
        foreach ($ticketMessages as $ticketMessage){
            if ($ticketMessage->aid != 0){
                $admin = Admin::where('aid', $ticketMessage->aid)->first();
                $ticketMessage->username = $admin->username;
                $ticketMessage->profile_picture_url = $admin->profile_picture_url;
            }
        }

        return view('pages.tickets.detail', [
            'ticket' => $ticket,
            'ticketMessages' => $ticketMessages,
            'username' => $user->username,
            'profile_picture_url' => $user->profile_picture_url
        ]);
    }

    public static function answer(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        if ($ticket == null){
            return redirect('/dashboard');
        }

        $ticketMessage = new TicketMessages();
        $ticketMessage->tid = $ticket->tid;
        $ticketMessage->aid = $admin->aid;
        $ticketMessage->message = $request->input('message');
        $ticketMessage->save();

        return redirect('/tickets/detail?tid=' . $ticket->tid);
    }

    public static function close(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        if ($ticket == null){
            return redirect('/dashboard');
        }

        LogController::writeLog($admin->username . " (" . $admin->aid . ") Closed ticket with id: " . $ticket->tid);

        $ticket->is_closed = 1;
        $ticket->save();
        return redirect('/tickets/');
    }

    public static function open(Request $request){
        $admin = SessionController::checkSession($request);
        if (!$admin)
            return redirect('/login');

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        if ($ticket == null){
            return redirect('/dashboard');
        }

        LogController::writeLog($admin->username . " (" . $admin->aid . ") Opened ticket with id: " . $ticket->tid);

        $ticket->is_closed = 0;
        $ticket->save();
        return redirect('/tickets/');
    }
}
