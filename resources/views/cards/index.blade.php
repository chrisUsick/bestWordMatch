@extends('layouts.app')

@section('content')
  <form action="/cards" method="get" class="form-inline">
    <div class="form-group">
      <input class="form-control" type="text" name="search" value="{{{isset($search) ? $search : ''}}}"/>
    </div>
    <div class="checkbox">
      <label>
        {{-- <input type="checkbox" name="exclude[]" value="green" checked="{{{array_search('green', $exclude) ? true : false }}}"/> Green --}}
      </label>
      <label>
        {{-- <input type="checkbox" name="exclude[]" value="red" checked="{{{array_search('green', $exclude) ? true : false }}}" /> Red --}}
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
  </form>
  <table>
    <thead>
      <th>
        Word
      </th>
      <th>
        Description
      </th>
      <th>
        Color
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
  {!! $cards->appends(['search'=> $search])->render() !!}
@endsection
