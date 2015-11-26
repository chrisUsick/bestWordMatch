<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\GameManager;
class GameChannel implements MessageComponentInterface {
  // list of clients
  protected $clients;
  protected $gameManager;
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
    $methodName = explode(':', $data->method)[1];
    $methodVariable = array($this, $methodName);
    if (is_callable($methodVariable)) {
      $this->$methodName($from, $data);
    }

  }

  public function register($conn, $data )
  {
    $game = $this->gameManager->getGame($data->gameId);
    $success = $game->registerPlayer($data->playerId);
    if ($success) {
      $data = [
        'method'=> 'game:myHand',
        'cards'=>['boo']
      ];
      $conn->send(json_encode($data));
    } else {
      $data = [
        'method' => 'game:error',
        'error' => 'failed to registered '
      ];
    }
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
    print_r($e->getgetLine());
    $conn->close();
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
