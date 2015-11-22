<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Services\LobbyService;
class BestWordMatchWS implements MessageComponentInterface {
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

        // check if enough people have joined to start a game
        $this->startGame();
        $this->notifyChange();
    }
    public function onMessage(ConnectionInterface $from, $msg) {
      $data = json_decode($msg);
      if ($data->method == 'lobby:register') {
        // $this->register($from, $data);
      }
    }
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $ticket = $this->tickets[$conn];
        $this->lobby->unregister($ticket);
        $this->notifyChange();
        echo "Connection {$conn->resourceId} has disconnected\nticket: {$this->tickets[$conn]}";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
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
      if ($this->clients->count() >= 4) {
        $clientsForGame = [];
        $ticketsForGame = [];
        for ($i=0; $i < 3; $i++) {
          $client = $this->clients[$i];
          $clientsForGame[] = $client;
          $ticketsForGame[] = $this->tickets[$client];

          // remove client from the lobby
          $this->tickets[$client] = undefined;
        }

        $this->gameManager->createGame($ticketsForGame);
      }
    }
}
