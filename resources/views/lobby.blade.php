@extends('layouts.app')

@section('content')
  <div>
    <h1>Lobby </h1>
    <div id="app" class="col-md-4 col-md-offset-4">
      <p rv-show="!connected">
        Connecting to the lobby...
      </p>
      <p rv-show="connected">
        Connected!
      </p>
    </div>
  </div>
@endsection

@section('scripts')
  {{-- <script src="{{asset('js/lobby.js')}}" type="text/javascript"></script> --}}
@endsection
