@extends('layouts.app')

@section('content')
  <div>
    <h1>Lobby </h1>
    <div class="row">
      <div id="lobby" class="col-md-4 col-md-offset-4">
        <p rv-hide="connected">
          Connecting to the lobby...
        </p>
        <p rv-show="connected">
          Connected!
        </p>
        <p>
          There <span rv-hide="oneTicket < tickets">are</span>
          <span rv-show="oneTicket < tickets">is</span> {tickets}
          <span rv-hide="oneTicket < tickets">people</span>
          <span rv-show="oneTicket < tickets">person</span>
          in the lobby.
        </p>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {{-- <script src="{{asset('js/lobby.js')}}" type="text/javascript"></script> --}}
@endsection
