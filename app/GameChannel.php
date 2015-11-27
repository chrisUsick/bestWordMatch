<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\GameManager;
class GameChannel implements MessageComponentInterface {
  // list of clients
  protected $clients;
  protected $gameManager;

  /**
   * map of $clients associated a game
   * @var array(gameId, SplObjectStorage(ConnectionInterface))
   */
  protected $games = array();
  // map<Client, tickets>
  public function __construct() {
    $this->clients = new \SplObjectStorage;
    $this->gameManager = gameManager::get();
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
      $this->send_myHand($conn, $game, $data->playerId);
      $this->addClientToGame($data->gameId, $conn);
      if ($game->allPlayersRegistered()) {
        $gameReadyData = [
          'method'=>'game:gameReady',
          'greenCard'=> json_decode($game->greenCard(), true),
          'judge' => $game->getJudge(),
          'players' => $game->getPlayers()
        ];
        $this->broadcastToGame($data->gameId, $gameReadyData);
      }
    } else {
      $errorMessage = [
        'method' => 'game:registrationError',
        'error' => 'failed to registered '
      ];
      $conn->send(json_encode($errorMessage));
    }
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
      if ($data->card) {
        $game->playCard($data->playerId, $data->card);
        $this->send_myHand($conn, $game, $data->playerId);
        // $this->send_cardPlayed($data->gameId);
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
      'method'=>'cardPlayed',
      'players'=>$game->getPlayers(),
      'judge' => $this->get
    ];
    foreach ($clients as $client) {

    }
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
    echo "Connection {$conn->resourceId} has disconnected\nticket: {$this->tickets[$conn]}";
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
