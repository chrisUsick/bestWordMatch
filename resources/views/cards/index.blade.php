@extends('layouts.app')
@section('content')
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
        @if($isAdmin)
          <th>
            <a href="{{route('cards.index', $params(['sort'=>'created_at', 'dir'=>!$dir]))}}">
              Created At
              @if($sort == 'created_at')
                <span class="glyphicon glyphicon-arrow-{{$dir ? 'up' : 'down'}}"></span>
              @endif
            </a>
          </th>
        @endif
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
            @if($isAdmin)
              <td>
                {{$card->created_at->toDateString()}}
              </td>
            @endif
            <td>
              {{$card->type->type}}
            </td>
            @if($isAdmin)
              <td>
                {!! Form::open(['url'=>"/cards/$card->id", 'method'=>'POST']) !!}
                  {{method_field('DELETE')}}

                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                {!! Form::close() !!}
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {!! $cards->appends($params())->render() !!}
@endsection
