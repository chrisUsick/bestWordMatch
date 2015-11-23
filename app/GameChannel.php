<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\LobbyService;
class GameChannel implements MessageComponentInterface {
  // list of clients
  protected $clients;

  // map<Client, tickets>
  public function __construct() {
    $this->clients = new \SplObjectStorage;
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
    // $data = [
    //   'method'=>'lobby:myTicket',
    //   'ticket'=>$ticket
    // ];
    // $conn->send(json_encode($data));

    // check if enough people have joined to start a game
    $this->notifyChange();
  }
  public function onMessage(ConnectionInterface $from, $msg) {
    $data = json_decode($msg);

  }
  public function onClose(ConnectionInterface $conn) {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);
    $this->notifyChange();
    echo "Connection {$conn->resourceId} has disconnected\nticket: {$this->tickets[$conn]}";
  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
    echo 'stack trace: ';
    print_r($e->getTrace());
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
        'method'=>'game:updated'
      ];
      $client->send(json_encode($msg));
    }
  }
}
