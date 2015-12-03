<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Redis;

class SeedDatabase2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed2';

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
      , ['The Wizzard of of Oz', 'something about a tin man...']
      , ['Laptop', 'a tiny personal computer']
      , ['a funny hat', 'there\'s a hat for everything']
      , ['Jonny Depp', 'actor']
      , ['the grocery store', 'pick up the milk and eggs']
    ];

    protected $greenCards  = [
      ['Lazy', 'Not enjoying work']
      , ['Boring', 'Not very fun']
    ];

    protected $redCardsJSON = [];
    protected $greenCardsJSON = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->redCardsJSON = $this->encodeCards($this->redCards);
        $this->greenCardsJSON = $this->encodeCards($this->greenCards);
    }

    public function encodeCards($array)
    {
      $result = [];
      foreach ($array  as $card) {
        $result[] =  json_encode(['word'=>$card[0], 'description'=>$card[1]]);
      }

      return $result;
    }

    public function saveCards($key, $cards)
    {
      foreach ($cards as $card) {
        Redis::sadd($key, $card);
      }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $this->saveCards('redCards', $this->redCardsJSON);
      $this->saveCards('greenCards', $this->greenCardsJSON);

      print_r(Redis::smembers('redCards'));
      print_r(Redis::smembers('greenCards'));
    }
}
