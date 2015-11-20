<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Redis;

class SeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database';

    /**
     * nested array of cards. each card has type: [word, description]
     * @var [type]
     */
    protected $redCards = [
      ['My love Life', 'Complicated']
      , ['Barack Obama', 'US President']
    ];

    protected $redCardsJSON = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        foreach ($this->redCards as $redCard) {
          $this->redCardsJSON[] = json_encode(['word'=>$redCard[0], 'description'=>$redCard[1]]);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      foreach ($this->redCardsJSON as $redCard) {
        Redis::sadd('redCards', $redCard);
      }

      print_r(Redis::smembers('redCards'));
    }
}
