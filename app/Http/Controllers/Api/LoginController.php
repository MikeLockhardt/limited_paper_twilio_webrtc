<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $api_url;

    public function __construct()
    {
        $this->api_url = config('services.kidsartworks')['api_url'];;
    }

    /**
     * Process a new call
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // $login_username = $request->input('email');
        // $login_password = $request->input('password');
        $client = new \GuzzleHttp\Client(['headers' => ['brand'=>'KidsArtworksNZ', 'Content-Type'=>'application/x-www-form-urlencoded']]);
        $api_request = $client->request('POST', $this->api_url.'/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => 'saykor',
                'password' => 'test123'
            ]
        ]);
        $this->api_token = json_decode($api_request->getBody()->getContents(),true)['access_token'];
        $request->session()->put('user_token', $this->api_token);
        //$api_response = $api_request->send();
        print_r($this->api_token);
    }

    public function gotoTest(Request $request){
        print_r($request->session()->get('user_token'));
    }
}
