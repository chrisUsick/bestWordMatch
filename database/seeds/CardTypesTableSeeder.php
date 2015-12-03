<?php

use Illuminate\Database\Seeder;

class CardTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('card_types')->delete();
      DB::table('card_types')->insert([
        'type'=>'green'
      ]);

      DB::table('card_types')->insert([
        'type'=>'red'
      ]);
    }
}
