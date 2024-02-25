<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessages;
use App\Models\User;
use App\Models\Admin;
use App\Http\Controllers\SessionController;
class TicketController extends Controller
{
    public static function store(Request $request){
        $token = $request->cookie('session_token');
        $uid = SessionController::validSession($token);

        if ($uid == false)
        {
            return redirect('/auth/login');
        }

        $ticket = new Ticket;
        $ticket->uid = $uid;
        $ticket->title = $request->input('title');
        $ticket->is_closed = 0;
        $ticket->save();

        $ticketMessage = new TicketMessages;
        $ticketMessage->tid = $ticket->tid;
        $ticketMessage->uid = $uid;
        $ticketMessage->message = $request->input('message');
        $ticketMessage->save();

        return redirect('/tickets/detail?tid=' . $ticket->tid);
    }

    public static function viewTickets(Request $request){
        $token = $request->cookie('session_token');
        $uid = SessionController::validSession($token);

        if ($uid == false)
        {
            return redirect('/auth/login');
        }

        $tickets = Ticket::where('uid', $uid)->get();

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

        $user = User::where('uid', $uid)->first();

        return view('pages.panel.all-tickets', [
            'tickets' => $tickets,
            'username' => $user->username,
            'profile_picture_url' => $user->profile_picture_url
        ]);
    }

    public static function viewTicketDetail(Request $request){
        $token = $request->cookie('session_token');
        $uid = SessionController::validSession($token);

        if ($uid == false)
        {
            return redirect('/auth/login');
        }

        $ticket = Ticket::where('tid', $request->input('tid'))->first();
        $user = User::where('uid', $uid)->first();
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

        return view('pages.panel.ticket-detail', [
            'ticket' => $ticket,
            'ticketMessages' => $ticketMessages,
            'username' => $user->username,
            'profile_picture_url' => $user->profile_picture_url
        ]);
    }

    public static function answer(Request $request){
        $token = $request->cookie('session_token');
        $uid = SessionController::validSession($token);

        if ($uid == false)
        {
            return redirect('/auth/login');
        }

        $ticket = Ticket::where('tid', $request->input('tid'))->first();

        if ($ticket->uid != $uid)
        {
            return redirect('/panel/home');
        }

        $ticketMessage = new TicketMessages;
        $ticketMessage->tid = $ticket->tid;
        $ticketMessage->uid = $uid;
        $ticketMessage->message = $request->input('message');
        $ticketMessage->save();

        return redirect('/tickets/detail?tid=' . $ticket->tid);
    }
}
