@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
  <!-- Main jumbotron -->
  <div class="jumbotron bicycle-polo-background">
    <div class="container bicycle-polo-text">
      <h1 class="text-center"><strong>Limited Papers Co.</strong></h1>
      <p>
      Buy printable paper and envelopes, heavyweight paper, digital and laser paper, recycled paper, specialty paper and more Today at <a href="https://www.limitedpapers.com/" target="_blank"> Limited Papers</a>.
      </p>

      <h3><strong>Having trouble with one of our products?</strong></h3>
      <p>
         Talk to one of our support agents now — or fill out the support form below and someone will call you later.
      </p>
      <p><a class="btn btn-primary btn-lg btn-block" href="#support" role="button">Get help</a></p>
    </div>
  </div>

  <div class="container">

    @include('_messages')

    <h2 id="support">Contact support</h2>

    <p class="lead">
      Talk with one of our support agents right now by clicking the "Call Support" button on the right. If you can't talk now, fill out a support ticket and an agent will call you later.
    </p>

    <div class="row">

      <div class="col-md-6 col-md-push-6">

        <div class="custom-select">
          <label>Please select the Support Agency:</label>
          <select id="select_agency" class="form-control  m-bot15">
            <option value="support_agent1">Support 1</option>
            <option value="support_agent2">Support 2</option>
            <option value="support_agent3">Support 3</option>
          </select>
        </div>

        <div class="panel panel-info client-controls">
          <div class="panel-heading">
            <h3 class="panel-title">Talk to support now</h3>
          </div>
          <div class="panel-body">
            <p><strong>Status</strong></p>
            <div class="well well-sm" id="call-status">
              Connecting to Twilio...
            </div>
            @if(isset($user_id))
              <button class="btn btn-lg btn-primary call-support-button" onclick="callSupport('{{$user_id}}')">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Call support
              </button>
            @else
              <button class="btn btn-lg btn-primary call-support-button" onclick="callSupport()">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Call support
              </button>
            @endif
            <button class="btn btn-lg btn-danger hangup-button" disabled onclick="hangUp()">Hang up</button>
          </div>
        </div>

      </div>
      
      <div class="col-md-6 col-md-pull-6">

          {!! Form::open(['url' => route('addMsgTicket')]) !!}
              <!-- <div class="form-group">
                  {!! Form::label('name') !!}
                  {!! Form::text('name', '', ['class' => 'form-control']) !!}
              </div> 
              <div class="form-group" hidden>
                  {!! Form::label('side', 'Side') !!}
                  {!! Form::text('side', 'client', ['class' => 'form-control']) !!}
              </div> 

              <div class="form-group" hidden>
                  {!! Form::label('request_type') !!}
                  {!! Form::text('request_type', 'request', ['class' => 'form-control']) !!}
              </div>-->

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
      </div>
    </div>

    <small class="pull-right">
      Header Director of Limited Papers <a href="https://www.limitedpapers.com/">Mark Jonassen</a>
    </small>
  </div>
  @endsection
