<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use App\BestWordMatchWS;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run the web server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
      // $port = intval($this->option('port'));
      $port = 9000;
      $this->info("Starting chat web socket server on port " . $port);

      $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new BestWordMatchWS()
                )
            ),
            $port,
            '0.0.0.0'
        );
        $server->run();
    }

    /**
  	 * Get the console command options.
  	 *
  	 * @return array
  	 */
  	public function getOptions()
  	{
  		return [
  			['port', 'p', InputOption::VALUE_OPTIONAL, 'Port where to launch the server.', 9090],
  		];
  	}
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $this->fire();
    }
}
?>
