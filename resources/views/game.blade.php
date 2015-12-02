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
      <span rv-show="hasPlayed" class="badge">Played</span>
      <span rv-show="isJudge" class="badge">Judge</span>
    </p>
    <div class="row">
      <div class="col-sm-2">
        <h2>My Cards</h2>
        <ul rv-each-card="myHand">
          <li rv-on-click="playCard">
            {card.word}: {card.description}
          </li>
        </ul>
      </div>
      <div class="col-sm-2">
        <h2>Players</h2>
        <ul rv-each-player="players">
          <li>
            {player.name}
            <span rv-show="player.judge" class="badge">judge</span>
            <span rv-show="player.played" class="badge">played</span>
            <span class="badge">score: {player.score}</span>
          </li>
        </ul>
      </div>
      <div class="col-sm-2">
        <h2>Green Card</h2>
        <p>
          {greenCard.word}: {greenCard.description}
        </p>
      </div>
      <div class="col-sm-2" rv-show="isJudge">
        <h2>Played Cards</h2>
        <ul rv-each-card="playedCards">
          <li rv-on-click="pickWinningCard">
            {card.word}: {card.description}
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
