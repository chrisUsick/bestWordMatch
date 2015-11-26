@extends('layouts.app')

@section('content')
<div>
  <h1>Best Word Match</h1>
  <div id="app">
    {{-- <p rv-hide="registrationError" rv-hide="gameStarted"> --}}
    <p rv-show="showWaitingMsg < registrationError gameStarted" class="alert alert-warning">
      Waiting for players to join. Once everyone is ready, the first green card will be played;
    </p>
    <p rv-show="gameStarted" class="alert alert-success">
      Game Started.
    </p>
    <p class="alert alert-danger" rv-show="registrationError">
      {registrationError}
    </p>
    <p rv-show="registered">
      Registered! Player ID: {playerId}
    </p>
    <div class="row">
      <div class="col-sm-2">
        <h2>My Cards</h2>
        <ul rv-each-card="myHand">
          <li>
            {card}
          </li>
        </ul>
      </div>
      <div class="col-sm-2">
        <h2>Green Card</h2>
        <p>
          {greenCard}
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
