<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/', 'HomeController@index');

Route::post(
    '/token',
    ['uses' => 'TokenController@newToken', 'as' => 'new-token']
);
Route::get(
    '/dashboard',
    ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']
);
Route::post(
    '/ticket',
    ['uses' => 'TicketController@newTicket', 'as' => 'new-ticket']
);
Route::post(
    '/support/call',
    ['uses' => 'CallController@newCall', 'as' => 'new-call']
);
Route::post(
    '/addTicket',
    ['uses' => 'TicketController@addTicket', 'as'=>'add-ticket']
);
Route::post(
    '/replyTicket',
    ['uses' => 'DashboardController@replyTicket', 'as'=>'reply-ticket']
);
Route::post(
    '/addCallTicket',
    ['uses' => 'TicketController@addCallTicket', 'as'=>'addCallTicket']
);

Route::get('/showRequest','TicketController@showTicket')->name('showRequest');


// newdashboard Controller
Route::get('/newdashboard','NewDashboardController@index')->name('newdashboard');
Route::post('/replyMsgTicket', ['uses'=>'NewDashboardController@replyMsgTicket','as'=>'replyMsgTicket']);
Route::post('/replyCallTicket', ['uses'=>'NewDashboardController@replyCallTicket','as'=>'replyCallTicket']);

// newClientTicket Controller
Route::get('/ticketlist', 'TicketListController@index')->name('showTicketlist');
Route::post('/addMsgTicket', ['uses' => 'TicketListController@addMsgTicket', 'as'=>'addMsgTicket']);
Route::post('/clientCallTicket', ['uses' => 'TicketListController@clientCallTicket', 'as'=>'clientCallTicket']);

//Message parsing controller
Route::post('/receiveMessage', ['uses'=>'InboundEmailController@parseMessage', 'as'=>'receiveMessage']);
Route::get('/receiveMessage', ['uses'=>'InboundEmailController@parseMessage', 'as'=>'receiveMessage']);
