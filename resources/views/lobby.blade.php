@extends('layouts.app')

@section('content')
  <div>
    <h1>Lobby </h1>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
        <div id="lobby" >
          <p rv-hide="connected">
            Connecting to the lobby...
          </p>
          <p rv-show="connected"  >
            Connected!
          </p>
          <p>
            There <span rv-hide="oneTicket < tickets">are</span>
            <span rv-show="oneTicket < tickets">is</span> {tickets}
            <span rv-hide="oneTicket < tickets">people</span>
            <span rv-show="oneTicket < tickets">person</span>
            in the lobby.
          </p>
          <div rv-show="gameLink">
            <p class="exclaim">
              Game Ready!
            </p>
            <a rv-href="gameLink" class="btn btn-success">Go to Game</a>
          </div>
        </div>
        <div id="echo">
          <p rv-show="connected">
            <input type="text" rv-value="message"/>
            <button rv-on-click="submit" class="btn btn-success">Send message</button>
            Connected!
          </p>
          <div rv-each-message="messages">
            <p>
              <span>{message.name}: </span>{message.message}
            </p>
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection

@section('scripts')
  {{-- <script src="{{asset('js/lobby.js')}}" type="text/javascript"></script> --}}
@endsection
