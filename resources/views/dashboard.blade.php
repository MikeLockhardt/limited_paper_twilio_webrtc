@extends('layouts.master')

@section('title')
    Support Dashboard
@endsection

@section('content')
  <div class="container">

    <h2>Support Tickets</h2>

    <p class="lead">
      This is the list of most recent support tickets. Click the "Call customer" button to start a phone call from your browser.
    </p>

    <div class="row">

      <div class="col-md-4 col-md-push-8">
        <div class="panel panel-primary client-controls">
          <div class="panel-heading">
            <h3 class="panel-title">Make a call</h3>
          </div>
          <div class="panel-body">
            <p><strong>Status</strong></p>
            <div class="well well-sm" id="call-status">
              Connecting to Twilio...
            </div>

            <button class="btn btn-lg btn-success answer-button" disabled>Answer call</button>
            <button class="btn btn-lg btn-danger hangup-button" disabled onclick="hangUp()">Hang up</button>
          </div>
        </div>

        <div class="panel panel-primary client-controls">
          <div class="panel-heading">
            <h3 class="panel-title">Send a Message</h3>
          </div>
          <div class="panel-body">
            {!! Form::open(['url' => route('reply-ticket')]) !!}
                <div class="form-group">
                    {!! Form::label('email') !!}
                    {!! Form::text('email', '', ['class' => 'form-control receiveAddress']) !!}
                </div>

                <div class="form-group" hidden>
                    {!! Form::label('type', 'Type') !!}
                    {!! Form::text('type', 'msg', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group" hidden>
                    {!! Form::label('parent_ticket_id', 'Parent Ticket ID') !!}
                    {!! Form::text('parent_ticket_id', '', ['class' => 'form-control parent_ticket_id']) !!}
                </div>
                 
                <div class="form-group" hidden>
                    {!! Form::label('user_ticket_id', 'Parent Ticket ID') !!}
                    {!! Form::text('user_ticket_id', '', ['class' => 'form-control user_ticket_id']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('content', 'Content') !!}
                    {!! Form::textarea('content', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit ticket</button>
                </div>
            {!! Form::close() !!}
          </div>
        </div>


      </div>

      <div class="col-md-8 col-md-pull-4">
        @foreach ($tickets as $ticket)
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Ticket #{{ $ticket->id }} <small class="pull-right">{{ $ticket->created_at}}</small></h3>
            </div>

            <div class="panel-body">

              <div class="pull-right">
                <button onclick="callCustomer('{{ $ticket->phone_number }}')" type="button" class="btn btn-primary btn-lg call-customer-button">
                    <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                    Call
                </button>
                <button onclick="configSMS('{{ $ticket->email }}', '{{$ticket->id}}', '{{$ticket->user_id}}')" type="button" class="btn btn-primary btn-lg call-customer-button">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    SMS
                </button>
              </div>

              <p><strong>Name:</strong> {{ $ticket->fname }} {{ $ticket->lname }}</p>
              <p><strong>Phone number:</strong> {{ $ticket->phone_number }}</p>
              <p><strong>Description:</strong></p>
              {{ $ticket->content }}

            </div>
          </div>
        @endforeach
      </div>

    </div>
  </div>
@endsection('content')
