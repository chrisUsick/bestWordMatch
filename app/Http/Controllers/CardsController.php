<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $search = $request->input('search');

      $exclude = $request->input('exclude') ? $request->input('exclude') : [];
      $dir = $request->input('dir');
      $sortParam = $request->input('sort');
      $orderBy =  $sortParam && ($sortParam != 'color') ? $sortParam : 'card_type_id';

      // $exclude =  [];
      $cards = \App\Card::whereHas('type', function($q) use ($exclude) {
          foreach ($exclude as $value) {
            $q->where('type', 'NOT LIKE', "%$value%");
          }
        })
        ->where(function($q) use ($search) {
          $q->orWhere('description', 'LIKE', "%$search%")
            ->orWhere('word', 'LIKE', "%$search%");
        })
        ->orderBy($orderBy, $dir ? 'asc' :'desc')
        ->orderBy('word', 'asc')
        ->paginate(20);

      return view('cards.index', [
        'cards'=>$cards,
        'title'=>'Cards',
        'search'=>$search,
        'exclude'=>$exclude,
        'sort'=>$sortParam,
        'dir'=>$dir,
        'params'=> function($params = []) use ($search, $exclude, $sortParam, $dir,$cards){
          $current = ['search'=> $search, 'exclude'=>$exclude, 'sort'=>$sortParam, 'dir'=>$dir, 'page'=>$cards->currentPage()];
          foreach ($params as $key => $value) {
            $current[$key] = $value;
          }
          return $current;
        }
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
