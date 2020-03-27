@extends('layouts.adminlayout')

@section('title')
    Support Dashboard
@endsection

@section('content')
    <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="chat-room">
                  <aside class="left-side">
                    <div>  
                      <div class="user-head">
                          <i class="fa fa-user"></i>
                          <h3>Contacts</h3>
                      </div>
                      <ul class="chat-list chat-user">
                        @foreach ($allContacts as $contact)
                            @if(isset($selectedContact[0]) && $contact->id == $selectedContact[0]->id)
                                <li id="activated_contact">
                                    <div>
                                        <a href="/newdashboard?user_id={{$contact->id}}">
                                            <i class="fa fa-circle text-success"></i>
                                            <span>{{$contact->fname}} {{$contact->lname}}</span>
                                        </a>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div>
                                        <a href="/newdashboard?user_id={{$contact->id}}">
                                            <i class="fa fa-circle text-success"></i>
                                            <span>{{$contact->fname}} {{$contact->lname}}</span>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                      </ul>
                      <!-- <footer>
                              <a class="chat-avatar" href="javascript:;">
                                  <img alt="" src="img/mail-avatar.jpg">
                              </a>
                              <div class="user-status">
                                  <i class="fa fa-circle text-success"></i>
                                  Available
                              </div>
                              
                      </footer> -->
                    </div>
                  </aside>
                  <aside class="mid-side">
                      <div class="chat-room-head">
                          <h3>Inbox</h3>
                          <div class="pull-right position">
                            <form action="#" >
                                <input type="text" placeholder="Search" class="form-control search-btn ">
                            </form>
                            
                          </div>
                          
                      </div>
                      <div class="chat-room-content">
                        @foreach ($allTickets as $ticket)
                            @if ($ticket->side == 'client')
                                @if ($ticket->type == 'msg')
                                    <div class="group-rom client-msg">
                                        <div class="first-part" >
                                            <div class="name-section pull-left">
                                                <b>{{$ticket->fname}} {{$ticket->lname}} < {{ $ticket->email}}></b> 
                                            </div>
                                            <div>
                                                <small class="pull-right">{{ $ticket->created_at}}</small>
                                            </div>
                                            </div>
                                        <div class="second-part"> 
                                            {{$ticket->content}}
                                        </div>
                                    </div>
                                @endif
                                @if ($ticket->type == 'call')
                                    <div class="group-rom client-msg">
                                        <div class="first-part" >
                                            <div class="name-section pull-left">
                                                <b>{{$ticket->fname}} {{$ticket->lname}} < {{ $ticket->email}}></b> 
                                            </div>
                                            <div>
                                                <small class="pull-right">{{ $ticket->created_at}}</small>
                                            </div>
                                            </div>
                                        <div class="second-part"> 
                                            <div class="call">
                                                <i class="fa fa-phone-square" aria-hidden="true"></i>
                                                {{$ticket->content}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($ticket->side == 'agency')
                                @if ($ticket->type == 'msg')
                                    <div class="group-rom agency-msg">
                                        <div class="first-part">
                                            <div class="name-section pull-left">
                                                <b>{{$ticket->fname}} {{$ticket->lname}} < {{ $ticket->email}}></b>
                                            </div>
                                            <div>
                                                <small class="pull-right">{{ $ticket->created_at}}</small>
                                            </div>
                                            </div>
                                        <div class="second-part"> 
                                            {{$ticket->content}}
                                        </div>
                                    </div>
                                @endif  
                                @if ($ticket->type == 'call')
                                    <div class="group-rom agency-msg">
                                        <div class="first-part">
                                            <div class="name-section pull-left">
                                                <b>{{$ticket->fname}} {{$ticket->lname}} < {{ $ticket->email}}></b>
                                            </div>
                                            <div>
                                                <small class="pull-right">{{ $ticket->created_at}}</small>
                                            </div>
                                            </div>
                                        <div class="second-part">
                                            <div class="call">
                                                <i class="fa fa-phone-square" aria-hidden="true"></i> 
                                                {{$ticket->content}}
                                            </div>
     
                                        </div>
                                    </div>
                                @endif  
                            @endif  
                        @endforeach  
                      </div>
                
                      <footer>
                            @if (isset($selectedContact[0]))  
                                <a class="btn btn-success" onclick="callCustomer('{{ $selectedContact[0]->phone_number }}','{{$selectedContact[0]->id}}')"  data-toggle="modal" href="#myModal" style="float:left;">
                                    <i class="fa fa-phone"></i> Call
                                </a>
                            @endif
                            <!--vertical center Modal start-->
                                <div class="modal fade modal-dialog-center" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                                  <div class="modal-dialog ">
                                      <div class="modal-content-wrap">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closeCallbox()">&times;</button>
                                                  <h4 class="modal-title">Call Status</h4>
                                              </div>
                                              <div class="modal-body" id="call-status">
                                                  Ready
                                              </div>
                                              <div class="modal-footer">
                                                  <button data-dismiss="modal" class="btn btn-default" onclick="hangUp()" type="button">Close</button>
                                                  <button class="btn btn-danger" onclick="hangUp()" type="button"> Hang up</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              <!-- vertical center Modal end -->

                              <!-- The Modal -->
                                <div id="incoming_modal" class="incoming_modal">
                                    <div class="modal-dialog ">
                                        <div class="modal-content-wrap">   
                                            <!-- Modal content -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closeCallbox()">&times;</button>
                                                    <h4 class="modal-title">Call Status</h4>
                                                </div>
                                                <div class="modal-body" id="call-status">
                                                    Ready
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-lg btn-success answer-button" disabled>Answer call</button>
                                                    <button class="btn btn-lg btn-danger hangup-button" disabled onclick="hangUp()">Hang up</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                          {!! Form::open(['url' => route('replyMsgTicket')]) !!}
                            @if (isset($selectedContact[0]))
                                <div class="form-group" hidden>
                                    {!! Form::label('email') !!}
                                    {!! Form::text('email',  $selectedContact[0]->email, ['class' => 'form-control receiveAddress']) !!}
                                </div>
                                <div class="form-group" hidden>
                                    {!! Form::label('user_ticket_id', 'Parent Ticket ID') !!}
                                    {!! Form::text('user_ticket_id',  $selectedContact[0]->id, ['class' => 'form-control user_ticket_id']) !!}
                                </div>
                            @endif    

                            <div class="form-group" hidden>
                                {!! Form::label('type', 'Type') !!}
                                {!! Form::text('type', 'msg', ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group" hidden>
                                {!! Form::label('parent_ticket_id', 'Parent Ticket ID') !!}
                                {!! Form::text('parent_ticket_id', '', ['class' => 'form-control parent_ticket_id']) !!}
                            </div>

                            <div class="form-group chat-txt">
                                {!! Form::text('content', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="btn-group">
                              <button type="button" class="btn btn-white"><i class="fa fa-meh-o"></i></button>
                              <button type="button" class="btn btn-white"><i class=" fa fa-paperclip"></i></button>
                            </div>
                            
                            <button type="submit" class="btn btn-danger">Send</button>
                           
                          {!! Form::close() !!}
            
                      </footer>
                  </aside>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      
      

@endsection('content')
