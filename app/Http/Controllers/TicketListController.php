<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\TicketList;
use Auth;
use Twilio\Jwt\ClientToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Events\TicketListUpdated;

class TicketListController extends Controller
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

    // show all request for each user
    public function index(Request $request){
        
        $user_id = Auth::user()->id;
        $allTickets = DB::table('users')->join('ticket_lists', 'users.id', '=', 'ticket_lists.user_id')->where('user_ticket_id', $user_id)->select('users.*', 'ticket_lists.*')->orderBy('ticket_lists.created_at')->get();
        return view('ticketlist', ['allTickets'=>$allTickets, 'user_id'=>$user_id]); 

    }

    

    // save new request to Ticket tabel
    public function addMsgTicket(Request $request){

        $messages = [
            'required' => 'The :attribute is mandatory'
        ];

        $this->validate(
            $request, [
                'content' => 'required'
            ], $messages
        );

        $user_id = Auth::user()->id;
        $newSupportTicket = new TicketList(array_merge($request->all(), ['user_id' => $user_id, 'side'=>'client', 'request_type'=>'request', 'user_ticket_id'=>$user_id]));
        $newSupportTicket->save();

        //lauch the updateticket event.
        event(new TicketListUpdated($newSupportTicket)); // broadcast `TicketListUpdated` event

        $request->session()->flash(
            'status',
            "We've received your support ticket. We'll be in touch soon!"
        );

        return redirect()->route('showTicketlist');
    }



    // store call ticket to db and show it to list
    public function clientCallTicket(Request $request){  
        

        $side = $request->input('side');
        $request_type = $request->input('request_type');
        $user_ticket_id = $request->input('user_ticket_id');
        $user_id = Auth::user()->id;
        $newSupportTicket = new TicketList(['user_id'=>$user_id, 'type'=>'call', 'content'=>'Calling', 'side'=>$side, 'request_type'=>$request_type, 'user_ticket_id'=>$user_ticket_id]);
        $newSupportTicket->save();

        
        return redirect()->route('showTicketlist');
    }

    //Parsing the inbound email
    public function parseMessage(Request $request){
        
    }
}
