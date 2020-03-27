<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\TicketList;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ABCEmail;

class DashboardController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {   
        //join two table to get email and ticket content.
        $tickets = DB::table('users')->join('ticket_lists', 'users.id', '=', 'ticket_lists.user_id')->select('users.*', 'ticket_lists.*')->get();
        return view('dashboard', ['tickets' => $tickets]);       
    }

    // make an answer of the request ticket in Dashboard
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
        $sender = $request->input('email');
        $newSupportTicket = new TicketList(array_merge($request->all(), ['user_id' => $user_id, 'side'=>'agency', 'request_type'=>'reply']));
        $newSupportTicket->save();

        $request->session()->flash(
            'status',
            "Success!"
        );
        
        //config the sendgrid api_key
        
        // $data = array ('bodyMessage' => $sender);
        // Mail::send('emailtest', $data, function ($message) {
        //     $message->from( 'donotreply@demo.com', 'Just Laravel' );
        //     $message->to($sender)->subject ( 'Just Laravel demo email using SendGrid' );
        // } );
        
        $data = ['bodyMessage' => $request->input('content')];
        Mail::to($sender)->send(new ABCEmail($data));
        
        $allTickets = DB::table('users')->join('ticket_lists', 'users.id', '=', 'ticket_lists.user_id')->select('users.*', 'ticket_lists.*')->get();
        return view('dashboard', ['tickets' => $allTickets]);  

    }
}
