@extends('layouts.app')

@section('content')
<div>
  <h1>Best Word Match</h1>
  <div id="app">
    <p>
      Waiting for players to join. Once everyone is ready, the first green card will be played;
    </p>
    <p rv-show="registered">
      Registered!
    </p>
    <div >
      <h2>My Cards</h2>
      <ul rv-each-card="myHand">
        <li>
          {card}
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection
