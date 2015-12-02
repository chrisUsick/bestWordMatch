<?php

namespace App\Services;
use Redis;
use App\Services\Game;

class GameManager {

  private static $instance;
  private function __construct() {

  }

  public static function get() {
    if (static::$instance === null) {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * create a game
   * @param tickets   int[]   Array of tickets to add to the game
   */
  public function createGame($tickets) {
    // create game
    $id = Redis::incr('gameId');

    // players set
    foreach ($tickets  as $ticket ) {
      Redis::sadd("game:$id:players", $ticket);
    }

    // copy cards list
    Redis::sunionstore("game:$id:redCards", "redCards");
    Redis::sunionstore("game:$id:greenCards", "greenCards");

    return $id;
  }

  /**
   * return a game object
   * @param  int $gameId id of the game
   * @return Game         game object
   */
  public function getGame($gameId)  {
    return new Game($gameId);
  }
}
?>
