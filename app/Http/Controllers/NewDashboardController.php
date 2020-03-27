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

class NewDashboardController extends Controller
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
    public function index(Request $request)
    {   
        if(Auth::user()->permission != "admin"){
            return redirect()-> route('login');
        }
        $user_id = $request->input('user_id');
        //determine the user id;      
        if($request->input('user_id')>0){
            $allTickets = DB::table('users')->join('ticket_lists', 'users.id', '=', 'ticket_lists.user_id')->where('user_ticket_id', $user_id)->select('users.*', 'ticket_lists.*')->orderBy('ticket_lists.created_at')->get();
            $selectedContact = User::where('id', $user_id)->get();
        }else{
            $selectedContact = [];
            $allTickets = DB::table('users')->join('ticket_lists', 'users.id', '=', 'ticket_lists.user_id')->select('users.*', 'ticket_lists.*')->get();
        }
        //get all client user in User table 
        $allContacts = User::where('permission', 'client')->get();
        //echo $allTickets;
        return view('newdashboard', ['allContacts' => $allContacts, 'allTickets'=>$allTickets, 'selectedContact'=>$selectedContact]);
            
    }


    // Reply the ticket from client
    public function replyMsgTicket(Request $request){
        
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
        
        // $data = array ('bodyMessage' => $request->input('content'));
        // Mail::send('emailtest', $data, function ($message) {
        //     $message->from( 'donotreply@demo.com', 'Marks' );
        //     $message->to('black.horse775588@gmail.com')->subject ( 'Limited Papers' );
        // } );
        
        $data = ['bodyMessage' => $request->input('content')];
        Mail::to($sender)->send(new ABCEmail($data));
        
        return redirect('/newdashboard?user_id='.$request->input('user_ticket_id'));  
    }

    public function replyCallTicket(Request $request){

        $side = $request->input('side');
        $request_type = $request->input('request_type');
        $user_ticket_id = $request->input('user_ticket_id');
        $user_id = Auth::user()->id;
        $newSupportTicket = new TicketList(['user_id'=>$user_id, 'type'=>'call', 'content'=>'Calling', 'side'=>$side, 'request_type'=>$request_type, 'user_ticket_id'=>$user_ticket_id]);
        $newSupportTicket->save();
        
        //return $user_ticket_id;
        return redirect('/newdashboard?user_id='.$user_ticket_id);
    }
    
}
