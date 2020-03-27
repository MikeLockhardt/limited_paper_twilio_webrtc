<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use Twilio\Twiml;

class CallController extends Controller
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
    public function newCall(Request $request)
    {
        $response = new Twiml();
        $callerIdNumber = config('services.twilio')['number'];

        $dial = $response->dial(['callerId' => $callerIdNumber]);

        $phoneNumberToDial = $request->input('phoneNumber');
        $support_agent = $request->input('agency');

        if (isset($phoneNumberToDial)) {
            $dial->number($phoneNumberToDial);
        } else {
            $dial->client($support_agent);
        }

        return $response;
    }

    // public function newCall2(Request $request)
    // {
    //     $response = new Twiml();
    //     $callerIdNumber = config('services.twilio')['number2'];

    //     $dial = $response->dial(['callerId' => $callerIdNumber]);

    //     $phoneNumberToDial = $request->input('phoneNumber');

    //     if (isset($phoneNumberToDial)) {
    //         $dial->number($phoneNumberToDial);
    //     } else {
    //         $dial->client('support_agent');
    //     }

    //     return $response;
    // }
}
