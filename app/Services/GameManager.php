<?php

namespace App\Services;

class GameManager {

  private $instance;
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

  }

  /**
   * return a game object
   * @param  int $gameId id of the game
   * @return Game         game object
   */
  public function getGame($gameId)  {

  }
}
?>
