@extends('layouts.master')

@section('title')
    Support Dashboard
@endsection

@section('content')
    <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="chat-room">
                  <aside class="mid-side">
                      <div class="chat-room-head">
                          <h3>Inbox</h3>
                          <form action="#" class="pull-right position">
                              <input type="text" placeholder="Search" class="form-control search-btn ">
                          </form>
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
                            <a class="btn btn-success" onclick="callSupport('{{$user_id}}')"  data-toggle="modal" href="#myModal" style="float:left;">
                                <i class="fa fa-phone"></i> Call
                            </a>
                            <!--vertical center Modal start-->
                            <div class="modal fade modal-dialog-center " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog ">
                                      <div class="modal-content-wrap">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                          {!! Form::open(['url' => route('addMsgTicket')]) !!}   
                            <div class="form-group" hidden>
                                {!! Form::label('type', 'Type') !!}
                                {!! Form::text('type', 'msg', ['class' => 'form-control']) !!}
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


                  <aside class="right-side">
                      <div class="user-head">
                          <a href="#" class="chat-tools btn-success"><i class="fa fa-cog"></i> </a>
                          <a href="#" class="chat-tools btn-key"><i class="fa fa-key"></i> </a>
                      </div>
                      <div class="invite-row">
                          <h4 class="pull-left">People</h4>
                      </div>
                      <ul class="chat-available-user">
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-success"></i>
                                  Jonathan Smith
                                  <span class="text-muted">3h:22m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-success"></i>
                                  Jhone Due
                                  <span class="text-muted">1h:2m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-success"></i>
                                  Franklyn Kalley
                                  <span class="text-muted">2h:32m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-danger"></i>
                                  Anjelina joe
                                  <span class="text-muted">3h:22m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-warning"></i>
                                  Aliace Stalvien
                                  <span class="text-muted">1h:12m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-muted"></i>
                                  Stive jones
                                 
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.html">
                                  <i class="fa fa-circle text-muted"></i>
                                  Jonathan Smith
                                 
                              </a>
                          </li>
                      </ul>
                      <footer>
                          <a href="#" class="guest-on">
                              <i class="fa fa-check"></i>
                              Guest Access On
                          </a>
                      </footer>
                  </aside>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
@endsection('content')
