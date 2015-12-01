<?php
namespace App\Services;

use Redis;

define('RED_CARDS', 2);
/**
 * Game class
 */
class Game {
  private $id;
  /**
   * contains the base key value
   * @var string
   */
  private $key;
  public function __construct($id) {
    $this->id = $id;
    $this->key = "game:$this->id:";
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
    // echo "players that aren't registered: $diffLength\n";
    return (count($diff) == 0);
  }

  public function greenCard()
  {
    $currentGreenCard = Redis::get("game:$this->id:greenCard");
    if (!$currentGreenCard) {
      // echo "game $this->id doesn't have a current card.\n";
      $currentGreenCard = $this->dealGreenCard();
    }
    // echo 'green card: ' . var_dump($currentGreenCard);
    return $currentGreenCard;
  }

  /**
   * set the game's green card
   * @return string json string of a green card
   */
  public function dealGreenCard()
  {
    $card = Redis::srandmember('greenCards');
    // echo "random green card: " . var_dump($card);
    Redis::set("game:$this->id:greenCard", $card);
    return $card;
  }

  public function getJudge()
  {
    $judge = Redis::get($this->key . "judge");
    if (!$judge) {
      $judge = $this->setJudge();
    }
    return $judge;

  }
  public function setJudge()
  {
    $judge = Redis::srandmember($this->key . "registeredPlayers");
    Redis::set($this->key . "judge", $judge);
    return $judge;
  }

  public function getRedCards($playerId)
  {
    $redCards = Redis::smembers("player:$playerId:redCards");
    if (count($redCards) == 0) {
      return $this->dealRedCards($playerId);
    }

    return $this->decodeRedCards($redCards);
  }

  /**
   * return a array cards. Cards are stored as associative arrays
   * @param  string playerId
   * @return array array of cards
   */
  public function dealRedCards($playerId, $count = RED_CARDS)
  {
    // get cards
    $cards = Redis::srandmember($this->key . "redCards", $count);
    // echo "found this many cards: " . count($cards);
    // echo "cards, $count" . var_dump($cards);
    // remove cards from game deck, add to player's hand
    foreach ($cards as $card) {
      Redis::srem($this->key . "redCards", $card);
      echo "adding card $card to player $playerId\n";
      Redis::sadd("player:$playerId:redCards", $card);
    }

    return $this->decodeRedCards($cards);
  }

  /**
   * decode an array of red cards
   */
  public function decodeRedCards($encodedCards)
  {
    $decoded = [];
    foreach ($encodedCards as $card) {
      $decoded[] = json_decode($card, true);
    }

    return $decoded;
  }

  public function getPlayers()
  {
    return Redis::smembers($this->key . "registeredPlayers");
  }

  /**
   * return the players that have played in the game
   * @return playerId[] players that have played
   */
  public function getPlayersPlayed()
  {
    return Redis::hvals($this->key . "playerCards");
  }
  /**
   * return the played cards
   * @return cards[] cards that have been played
   */
  public function getCardsPlayed()
  {
    return $this->decodeRedCards(Redis::hkeys($this->key . "playerCards"));
  }

  /**
   * true if all players have played cards
   * @return bool
   */
  public function allPlayersPlayed()
  {
    $players = $this->getPlayers();
    $playersPlayed = $this->getPlayersPlayed();
    $playersNotPlayed = array_diff($players, $playersPlayed);
    $judge = $this->getJudge();
    $allPlayed = (in_array($judge, $playersNotPlayed) && count($playersNotPlayed) == 1);
    echo "have all players played? $allPlayed";
    return $allPlayed;
  }

  /**
   * add the card to the game's played cards deck and give the palyer a new card
   * @return void
   */
  public function playCard($playerId, $card)
  {
    Redis::hset($this->key . "playerCards", $card, $playerId);
    Redis::srem("player:$playerId:redCards", $card);
    $this->dealRedCards($playerId, 1);
  }

  public function pickWinningCard($card)
  {
    // incr winning players score
    $winningPlayer = Redis::hget($this->key . "playerCards", $card);
    Redis::hincrby($this->key . "scores", $winningPlayer, 1);
    // reset necessary game state
    // set judge
    Redis::set($this->key . "judge", $winningPlayer);
    // clear playerCards
    Redis::del($this->key . "playerCards");

    // get new green card
    $this->dealGreenCard();
  }

  public function getPlayerScores()
  {
    $scoresArr = Redis::hgetall($this->key . "scores");
    // $returnVal = [];
    // for ($i=0; $i < count($scoresArr) - 2; $i+=2) {
    //   $key = $scoresArr[$i];
    //   $score = $scoresArr[$i + 1];
    //   $returnVal[$key] = $score;
    // }
    // echo "player scores: \n";
    // var_dump($returnVal);
    // var_dump($scoresArr);
    return $scoresArr;
  }
}
