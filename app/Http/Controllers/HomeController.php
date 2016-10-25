<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $to_reply_group = array(env('TICKET_STATUS_NEW_ID'), env('TICKET_STATUS_OPEN_ID'), env('TICKET_STATUS_NEW_MODERATED_ID'));
        $tickets = Ticket::with('user', 'ticketstatus', 'product', 'ticketcategory')->whereIn('ticketstatus_id', $to_reply_group)->orderBy('updated_at', 'asc')->take(10)->get();
        $pagination = false;
        $dashboard = true;
        return view('ticket-admin.index', compact('tickets', 'pagination', 'dashboard'));
    }
}
