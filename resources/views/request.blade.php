@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')

  <div class="container">

    @include('_messages')

    <h2 id="support">Your Requests</h2>



    <div class="row">

      <div class="col-md-6 col-md-push-6">
          {!! Form::open(['url' => route('add-ticket')]) !!}
              <!-- <div class="form-group">
                  {!! Form::label('name') !!}
                  {!! Form::text('name', '', ['class' => 'form-control']) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('phone_number', 'Phone number') !!}
                  {!! Form::text('phone_number', '', ['class' => 'form-control']) !!}
              </div> -->
              
              <div class="form-group" hidden>
                  {!! Form::label('type', 'Type') !!}
                  {!! Form::text('type', 'msg', ['class' => 'form-control']) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('content', 'Description') !!}
                  {!! Form::textarea('content', '', ['class' => 'form-control']) !!}
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block">Submit ticket</button>
              </div>
          {!! Form::close() !!}
        <div class="panel panel-info client-controls">
          <div class="panel-heading">
            <h3 class="panel-title">Talk to support now</h3>
          </div>
          <div class="panel-body">
            <p><strong>Status</strong></p>
            <div class="well well-sm" id="call-status">
              Connecting to Twilio...
            </div>

            <button class="btn btn-lg btn-primary call-support-button" onclick="callSupport()">
              <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Call support
            </button>
            <button class="btn btn-lg btn-danger hangup-button" disabled onclick="hangUp()">Hang up</button>
          </div>
        </div>

      </div>
     
      <div class="col-md-6 col-md-pull-6">
            @foreach ($tickets as $ticket)
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <h3 class="panel-title">Ticket #{{ $ticket->id }} <small class="pull-right">{{ $ticket->created_at}}</small></h3>
                    </div>

                    <div class="panel-body">

                    <!-- <div class="pull-right">
                        <button onclick="callCustomer('{{ $ticket->phone_number }}')" type="button" class="btn btn-primary btn-lg call-customer-button">
                            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                            Call customer
                        </button>
                    </div> -->

                    <p><strong>Description:</strong></p>
                    {{ $ticket->content }}

                    </div>
                </div>
            @endforeach  
          

      </div>
    </div>

    <small class="pull-right">
      Header Director of Limited Papers <a href="https://www.limitedpapers.com/">Mark Jonassen</a>
    </small>
  </div>
  @endsection
