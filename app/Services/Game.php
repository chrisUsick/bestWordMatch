<?php
namespace App\Services;

use Redis;

/**
 * Game class
 */
class Game {
  private $id;
  public function __construct($id) {
    $this->id = $id;
  }

  public function registerPlayer($playerId)
  {
    $playerIsInGame = Redis::sismember("game:$this->id:players", $playerId);
    if ($playerIsInGame) {
      Redis::sadd("game:$this->id:registeredPlayers", $playerId);
    }

    return $playerIsInGame;
  }
}
