<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\LobbyService;
class EchoChannel implements MessageComponentInterface {
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
    echo "New echo connection! ({$conn->resourceId})\n";

  }
  public function onMessage(ConnectionInterface $from, $msg) {
    $data = json_decode($msg);
    echo $data->message . " sent from client: $from->resourceId\n";
    // $from->send(json_encode($data));
    $this->broadcast($msg);

  }
  public function onClose(ConnectionInterface $conn) {
    // The connection is closed, remove it, as we can no longer send it messages
    $this->clients->detach($conn);

    // $data = [
    //   'fromServer'=>true,
    //   'message'=> $this->tick' disconnected'
    // ];
    // $this->broadcast(json_encode($data));
    echo "Connection {$conn->resourceId} has disconnected from echo channel\n ";
  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
    echo 'stack trace: ';
    // print_r($e->getTrace());
    echo "An error has occurred on echo: {$e->getMessage()}\n";
    print_r($e->getFile());
    print_r($e->getgetLine());
    $conn->close();
  }

  public function broadcast($msg)
  {
    foreach ($this->clients as $client) {
      $client->send($msg);
    }
  }

}
