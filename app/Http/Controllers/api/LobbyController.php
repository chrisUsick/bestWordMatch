<?php

namespace App\Http\Controllers\Api;

// use App\User;
use Redis;
use App\Http\Controllers\Controller;

class LobbyController extends Controller
{
    /**
     * GET /api/lobby/join
     * @return JSON  returns ticket
     */
    public function getJoin()
    {
      $id = Redis::incr('ticketId');
      Redis::rpush('tickets', $id);
      return response()->json(['ticket'=>$id]);
    }

    public function getTickets() {
      $tickets = Redis::llen('tickets');
      return response()->json(['tickets'=>$tickets]);
    }
}
?>
