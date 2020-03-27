<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\TicketList;


class InboundEmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Process a new call
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function parseMessage(Request $request)
    {
        // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        // $txt = "John Doe\n";
        // fwrite($myfile, $txt);
        // $txt = "Jane Doe\n";
        // fwrite($myfile, $txt);
        // fclose($myfile);
        // echo "hello";

        $newSupportTicket = new TicketList(['user_id' => 1111, 'type'=>'Email', 'content'=>'User Email', 'parent_ticket_id'=>2222,'side'=>'host', 'request_type'=>'email', 'user_ticket_id'=>2222]);
        $newSupportTicket->save();
    }

}
