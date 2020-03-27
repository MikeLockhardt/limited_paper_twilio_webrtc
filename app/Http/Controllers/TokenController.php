<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Depart;
use Twilio\Jwt\ClientToken;
use Illuminate\Support\Facades\DB;
use Auth;


class TokenController extends Controller
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
     * Create a new capability token
     *
     * @return \Illuminate\Http\Response
     */
    public function newToken(Request $request, ClientToken $clientToken)
    {
        $forPage = $request->input('forPage');
        $applicationSid = config('services.twilio')['applicationSid'];
        $clientToken->allowClientOutgoing($applicationSid);

        if ($forPage === route('newdashboard', [], false)) {
            $organization_id = Auth::user()->organization_id; 
            $organization = DB::table('departs')->where('id', $organization_id)->select('title')->get();
            $clientToken->allowClientIncoming($organization[0]->title);
            //$clientToken->allowClientIncoming('support_agent');
        } else {
            $clientToken->allowClientIncoming('customer');
        }

        $token = $clientToken->generateToken();
        return response()->json(['token' => $token]);
       
    }
}
