<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\GameManager;
class GameChannel implements MessageComponentInterface {
  // list of clients
  protected $clients;
  protected $gameManager;
  protected $playerIdToClient;

  /**
   * map of $clients associated a game
   * @var array(gameId, SplObjectStorage(ConnectionInterface))
   */
  protected $games = array();
  // map<Client, tickets>
  public function __construct() {
    $this->clients = new \SplObjectStorage;
    $this->gameManager = gameManager::get();
    $this->playerIdToClient = array();
  }

  /**
  * create a ticket for the given connection
  * @param  ConnectionInterface $conn [description]
  * @return [type]                    [description]
  */
  public function onOpen(ConnectionInterface $conn) {
    // Store the new connection to send messages to later
    $this->clients->attach($conn);
    echo "New *game* connection! ({$conn->resourceId})\n";

  }
  public function onMessage(ConnectionInterface $from, $msg) {
    $data = json_decode($msg);
    // echo "got message: $msg\n";
    $methodName = "msg_" . explode(':', $data->method)[1];
    $methodVariable = array($this, $methodName);
    if (is_callable($methodVariable)) {
      $this->$methodName($from, $data);
    }

  }

  public function msg_register($conn, $data )
  {
    $game = $this->gameManager->getGame($data->gameId);
    $success = $game->registerPlayer($data->playerId);
    if ($success) {
      $this->playerIdToClient[$data->playerId] = $conn;
      $this->send_myHand($conn, $game, $data->playerId);
      $this->addClientToGame($data->gameId, $conn);
      if ($game->allPlayersRegistered()) {
        $this->send_roundReady($data->gameId);

        if ($data->playerId == $game->getJudge()) {
          $this->send_playedCards($data->gameId);
        }
      }
    } else {
      $errorMessage = [
        'method' => 'game:registrationError',
        'error' => 'failed to registered '
      ];
      $conn->send(json_encode($errorMessage));
    }
  }

  public function send_roundReady($gameId)
  {
    $game = $this->gameManager->getGame($gameId);
    $roundReadyData = [
          'method'=>'game:roundReady',
          'greenCard'=> json_decode($game->greenCard(), true),
          'judge' => $game->getJudge(),
          'players' => $game->getPlayers(),
          'playersPlayed' => $game->getPlayersPlayed(),
          'playerScores' => $game->getPlayerScores()
        ];

    $this->broadcastToGame($gameId, $roundReadyData);
  }

  public function send_myHand($client, $game, $playerId)
  {
    $successData = [
        'method'=> 'game:myHand',
        'cards'=> $game->getRedCards($playerId)
      ];
      $client->send(json_encode($successData));
  }

  public function msg_playCard($conn, $data)
  {
    try {
      $game = $this->gameManager->getGame($data->gameId);
      if ($data->card && $game->getJudge() != $data->playerId) {
        $game->playCard($data->playerId, $data->card);
        $this->send_myHand($conn, $game, $data->playerId);
        $this->send_cardPlayed($data->gameId);
      }
    } catch (Exception $e) {
      $this->send_unknownError($conn, $e->getMessage());
    }

  }

  public function send_unknownError($conn, $msg)
  {
    $data = [
      'method'=>'game:unknownError',
      'message'=> $msg
    ];

    $conn->send(json_encode($data));
  }

  /**
   * send the players list to all players
   * send the played cards to the judge
   * @return void
   */
  public function send_cardPlayed($gameId)
  {
    $clients = $this->games[$gameId];
    $game = $this->gameManager->getGame($gameId);
    $data = [
      'method'=>'game:cardPlayed',
      'players'=>$game->getPlayers(),
      'judge' => $game->getJudge(),
      'playersPlayed' => $game->getPlayersPlayed(),
      'playerScores' => $game->getPlayerScores()
    ];
    $this->broadcastToGame($gameId, $data);

    // only send the judge the cards if all players have played
    if ($game->allPlayersPlayed()) {
      $this->send_playedCards($gameId);
    }
  }

  /**
   * send a message to the judge of the game showing all the cards played
   */
  public function send_playedCards($gameId)
  {
    $game = $this->gameManager->getGame($gameId);
    $judge = $game->getJudge();
    $client = $this->playerIdToClient[$judge];
    $data = [
      'method' => 'game:playedCards',
      'playedCards' => $game->getCardsPlayed()
    ];
    $client->send(json_encode($data));
  }

  public function broadcastToGame($gameId, $data)
  {
    $clients = $this->games[$gameId];
    foreach ($clients as $client) {
      $client->send(json_encode($data));
    }
  }

  public function addClientToGame($gameId, $client) {
    if (!isset($this->games[$gameId])) {
      $this->games[$gameId] = new \SplObjectStorage;
    }
    $this->games[$gameId]->attach($client);
  }
  public function onClose(ConnectionInterface $conn) {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);
    echo "Connection {$conn->resourceId} has disconnected from game\n ";
  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
    echo 'stack trace: ';
    echo $e->getTraceAsString();
    echo "An error has occurred: {$e->getMessage()}\n";
    print_r($e->getFile());
    print_r($e->getLine());
    // $conn->close();
    $this->send_unknownError($conn, "unknown error occured");
  }

  public function msg_pickWinningCard($client, $data)
  {
    // update game
    $game = $this->gameManager->getGame($data->gameId);
    if ($data->winningCard) {
      $game->pickWinningCard($data->winningCard);
    }
    // send game ready event to sync up players
    $this->send_roundReady($data->gameId);
  }

  public function notifyChange()
  {
    foreach ($this->clients as $client) {
      $msg = [
        'method'=>'game:updated'
      ];
      $client->send(json_encode($msg));
    }
  }
}
