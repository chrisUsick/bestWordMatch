<?php namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// use App\LobbyChannel;
class BestWordMatchWS implements MessageComponentInterface {
    // list of clients
    protected $clients;
    protected $channels;
    protected $clientChannels;

    // Map<channelId, channel>
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->channels = array();
        $this->clientChannels = new \SplObjectStorage;

        $this->channels['lobby'] = new LobbyChannel();
        $this->channels['game'] = new GameChannel();
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
    }

    public function onMessage(ConnectionInterface $from, $msg) {
      $data = json_decode($msg);
      echo $msg . '\n';
      if ($data->method == 'join') {
        $channel = $this->channels[$data->channel];

        if ($channel) {
          $channel->onOpen($from);

          // assign client to a channel
          $this->clientChannels[$from] = $channel;
        } else {
          $data = ['method'=>'error', 'error'=>'no channel ' . $data->channel . ' found'];
          $from->send(json_encode($data));
        }

      } else {
        $this->sendMessageToChannel($from, $data, $msg);
      }
    }
    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\nticket: {$this->tickets[$conn]}";
        echo "discconnedted";
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        // $channel = $this->clientChannels[$conn];
        // if ($channel) {
        //   $channel->onClose($conn);
        // }

        echo "Connection {$conn->resourceId} has disconnected\nticket: {$this->tickets[$conn]}";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo 'stack trace: ';
        print_r($e->getTrace());
        echo "An error has occurred: {$e->getMessage()}\n";
        print_r($e->getFile());
        print_r($e->getgetLine());
        $conn->close();
        // $this->onClose($conn);
    }

    public function sendMessageToChannel($conn, $data, $msg)
    {
      // $channelName = explode(':', $data->method)[0];
      $channel = $this->clientChannels[$conn];
      // if (strpos($data->method, ':') !== FALSE) {
      //   $this->channels[$channelName]->onMessage($conn, $msg);
      // }
      if ($channel) {
        $channel->onMessage($conn, $msg);
      } else {
        $data = ['method'=>'error', 'error'=>'not connected to client'];
        $conn->send(json_encode($data));
      }
    }

}
