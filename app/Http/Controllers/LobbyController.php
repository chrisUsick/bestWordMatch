<?php

namespace App\Http\Controllers;

// use App\User;
use App\Http\Controllers\Controller;

class LobbyController extends Controller
{
    public function lobby()
    {
      return view('lobby', ['title' => 'Lobby']);
    }
}
?>
