<?php

namespace App\Http\Controllers\Api;

// use App\User;
use Redis;
use App\Http\Controllers\Controller;
use App\Services\LobbyService;

class LobbyController extends Controller
{
    public function __construct()
    {
      $this->lobby = LobbyService::get();
    }

    public function getTickets() {
      $tickets = $this->lobby->getTickets();
      return response()->json(['tickets'=>  count($tickets)]);
    }
}
?>
