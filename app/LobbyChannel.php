<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\LobbyService;
use App\Services\GameManager;
class LobbyChannel implements MessageComponentInterface {
  // list of clients
  protected $clients;

  // map<Client, tickets>
  protected $tickets;
  protected $lobby;
  protected $gameManager;
  public function __construct() {
    $this->clients = new \SplObjectStorage;
    $this->tickets = new \SplObjectStorage;
    $this->lobby = LobbyService::get();
    $this->gameManager = GameManager::get();
  }

  /**
  * create a ticket for the given connection
  * @param  ConnectionInterface $conn [description]
  * @return [type]                    [description]
  */
  public function onOpen(ConnectionInterface $conn) {
    // Store the new connection to send messages to later
    $this->clients->attach($conn);
    echo "New connection! ({$conn->resourceId})\n";
    $ticket = $this->lobby->register();
    $this->register($conn, $ticket);
    $data = [
      'method'=>'lobby:myTicket',
      'ticket'=>$ticket
    ];
    $conn->send(json_encode($data));

    $this->notifyChange();
    // check if enough people have joined to start a game
    $this->startGame();
  }
  public function onMessage(ConnectionInterface $from, $msg) {
    $data = json_decode($msg);

  }
  public function onClose(ConnectionInterface $conn) {
    // The connection is closed, remove it, as we can no longer send it messages
    try {
      $this->clients->detach($conn);
      $ticket = $this->tickets->offsetGet($conn);
      $this->tickets->offsetSet($conn);
      $this->lobby->unregister($ticket);
      $this->notifyChange();
      echo "Connection {$conn->resourceId}, ticket: {$ticket}, has disconnected from lobby channel\n";
    } catch (Exception $e) {
      echo 'error on close in lobby channel';
    }


  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
    echo 'stack trace: ';
    echo $e->getTraceAsString();
    echo "An error has occurred: {$e->getMessage()}\n";
    print_r($e->getFile());
    print_r($e->getgetLine());
    $conn->close();
  }

  /**
  * map a client to a ticket
  * @param  ConnectionInterface $conn   [description]
  * @param  [type]              $ticket [description]
  * @return [type]                      [description]
  */
  public function register(ConnectionInterface $conn, $ticket) {
    echo "mapping connection {$conn->resourceId} to ticket {$ticket}\n";
    $this->tickets[$conn] = $ticket;
  }

  public function notifyChange()
  {
    foreach ($this->clients as $client) {
      $msg = [
        'method'=>'lobby:updated'
      ];
      $client->send(json_encode($msg));
    }
  }

  public function startGame()
  {
    // if enough players start game
    if ($this->clients->count() >= 2) {
      $clientsForGame = [];
      $ticketsForGame = [];

      // loop through clients
      $this->clients->rewind();
      while ($this->clients->valid()) {
        $client = $this->clients->current();
        $clientsForGame[] = $client;
        $ticketsForGame[] = $this->tickets[$client];
        // echo "all the tickets\n";
        $this->clients->next();
      }
      // print_r($clientsForGame);
      // var_dump($ticketsForGame);
      $gameId = $this->gameManager->createGame($ticketsForGame);
      $this->notifyGameReady($clientsForGame, $gameId);
    }  else {
      echo "lobby: not enough players for a game\n";
    }
  }

  public function notifyGameReady($clients, $gameId)
  {
    $data = [
      'method' => 'lobby:gameReady',
      'gameId' => $gameId
    ];
    foreach ($clients as $client ) {
      $client->send(json_encode($data));
    }
  }
}
