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

  public function allPlayersRegistered()
  {
    $diff = Redis::sdiff("game:$this->id:players", "game:$this->id:registeredPlayers");
    $diffLength = count($diff);
    echo "players that aren't registered: $diffLength\n";
    return (count($diff) == 0);
  }

  public function greenCard()
  {
    $currentGreenCard = Redis::get("game:$this->id:greenCard");
    if (!$currentGreenCard) {
      echo "game $this->id doesn't have a current card.\n";
      $currentGreenCard = $this->dealGreenCard();
    }
    echo 'green card: ' . var_dump($currentGreenCard);
    return $currentGreenCard;
  }

  /**
   * set the game's green card
   * @return string json string of a green card
   */
  public function dealGreenCard()
  {
    $card = Redis::srandmember('greenCards');
    echo "random green card: " . var_dump($card);
    Redis::set("game:$this->id:greenCard", $card);
    return $card;
  }
}
