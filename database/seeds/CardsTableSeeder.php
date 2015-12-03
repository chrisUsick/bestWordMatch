<?php

use Illuminate\Database\Seeder;
class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('cards')->delete();
      // $redId = CardType::where('type', 'red')->first();
      $redId = DB::table('card_types')->select('id')->where('type', '=', 'red')->get()[0]->id;
      DB::table('cards')->insert([
        'word'=>'foo',
        'description'=>'blah blah',
        'card_type_id'=>$redId
      ]);

      $xml = DOMDocument->load('greenWords.xml');
      

    }
}
