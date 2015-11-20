<?php
namespace App\Services;

use Redis;

/**
 * Lobby Service
 */
class LobbyService
{

  private static $instance;
  private function __construct()
  {
  }

  public static function get()
  {
    if(null === static::$instance) {
      static::$instance = new static();
    }
    return LobbyService::$instance;
  }


  public function register() {
    $id = Redis::incr('ticketId');
    Redis::rpush('tickets', $id);
    return $id;
  }

  public function unregister($ticket) {
    Redis::lrem('tickets', 0, $ticket);
  }

  public function getTickets()
  {
    return Redis::lrange('tickets', 0,-1);
  }
}

?>
