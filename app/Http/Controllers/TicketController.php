<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\TicketList;
use Auth;
use Twilio\Jwt\ClientToken;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
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
     * Store a new ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newTicket(Request $request)
    {
        $messages = [
            'required' => 'The :attribute is mandatory',
            'phone_number.regex' => 'The phone number must be in E.164 format'
        ];

        $this->validate(
            $request, [
                'name' => 'required',
                // E.164 format
                'phone_number' => 'required|regex:/^\+[1-9]\d{1,14}$/',
                'description' => 'required'
            ], $messages
        );

        $newTicket = new Ticket($request->all());
        $newTicket->save();

        $request->session()->flash(
            'status',
            "We've received your support ticket. We'll be in touch soon!"
        );

        return redirect()->route('home');
    }

    // save new request to Ticket tabel
    public function addTicket(Request $request){

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

        $request->session()->flash(
            'status',
            "We've received your support ticket. We'll be in touch soon!"
        );

        return redirect()->route('showRequest');
    }

    // show all request for each user
    public function showTicket(Request $request){
        
        $user_id = Auth::user()->id;
        $allTickets = TicketList::where('user_id', $user_id)->get();
        return view('request', ['tickets' => $allTickets]); 

    }


    // show all request for each user
    public function replyTicket(Request $request){

        $messages = [
            'required' => 'The :attribute is mandatory'
        ];

        $this->validate(
            $request, [
                'email'=> 'required',
                'content' => 'required'
            ], $messages
        );

        $user_id = Auth::user()->id;
        $newSupportTicket = new TicketList(array_merge($request->all(), ['user_id' => $user_id, 'side'=>'agency', 'request_type'=>'reply']));
        $newSupportTicket->save();

        $request->session()->flash(
            'status',
            "Success!"
        );
        
        return redirect()->route('showRequest');

    }



    public function addCallTicket(Request $request){  
        

        $side = $request->input('side');
        $request_type = $request->input('request_type');
        $user_ticket_id = $request->input('user_ticket_id');
        $user_id = Auth::user()->id;
        $newSupportTicket = new TicketList(['user_id'=>$user_id, 'type'=>'call', 'content'=>'Calling', 'side'=>$side, 'request_type'=>$request_type, 'user_ticket_id'=>$user_ticket_id]);
        $newSupportTicket->save();

        $request->session()->flash(
            'status',
            "Success Call"
        );
        
        //return $user_ticket_id;
        return redirect('/newdashboard');
    }
}
