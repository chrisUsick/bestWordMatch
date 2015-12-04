@extends('layouts.app')
@section('content')
  {{-- <form action="/cards" method="get" class="form-inline">
    <div class="form-group">
      <input class="form-control" type="text" name="search" value="{{{isset($search) ? $search : ''}}}"/>
    </div>
    <div class="checkbox">
      <label>
        {{$exclude}}
        <input type="checkbox" name="exclude[]" value="green" checked=""/> Green
        <input type="checkbox" name="exclude[]" value="green" checked="{{{array_search('green', $exclude) ? true : false }}}"/> Green
      </label>
      <label>
        <input type="checkbox" name="exclude[]" value="red" checked="{{{array_search('green', $exclude) ? true : false }}}" /> Red
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
  </form> --}}
  {!! Form::open(['url'=>route('cards.index'), 'method'=>'get', 'class'=>'form-inline']) !!}
    <div class="form-group">
      {!! Form::text('search', isset($search) ? $search : '', ['class'=>'form-control']) !!}
    </div>
    Exclude Color:
    <div class="checkbox">
      {!! Form::checkbox('exclude[]', 'green', in_array('green', $exclude)) !!}
      {!! Form::label('green', 'Green') !!}
      {!! Form::checkbox('exclude[]', 'red', in_array('red', $exclude)) !!}
      {!! Form::label('red', 'Red') !!}
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
  {!! Form::close() !!}
  {{$cards->total()}}
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <th>
          <a href="{{route('cards.index', $params(['sort'=>'word', 'dir'=>!$dir]))}}">
            Word
            @if($sort == 'word')
              <span class="glyphicon glyphicon-arrow-{{$dir ? 'up' : 'down'}}"></span>
            @endif
          </a>
        </th>
        <th>
          <a href="{{route('cards.index', $params(['sort'=>'description', 'dir'=>!$dir]))}}">
            Description
            @if($sort == 'description')
              <span class="glyphicon glyphicon-arrow-{{$dir ? 'up' : 'down'}}"></span>
            @endif
          </a>
        </th>
        <th>
          <a href="{{route('cards.index', $params(['sort'=>'color', 'dir'=>!$dir]))}}">
            Color
            @if($sort == 'color')
              <span class="glyphicon glyphicon-arrow-{{$dir ? 'up' : 'down'}}"></span>
            @endif
          </a>
        </th>
      </thead>
      <tbody>
        @foreach($cards as $card)
          <tr>
            <td>
              {{$card->word}}
            </td>
            <td>
              {{$card->description}}
            </td>
            <td>
              {{$card->type->type}}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {!! $cards->appends($params())->render() !!}
@endsection
