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
      $greenId = DB::table('card_types')->select('id')->where('type', '=', 'green')->get()[0]->id;

      foreach (['redCards.xml'=>$redId, 'greenCards.xml'=>$greenId] as $fileName => $id) {
        $DOM = new DOMDocument;
        $DOM->load(__DIR__ . '/' . $fileName);
        $DOM->normalize();
        foreach ($DOM->getElementsByTagName('card') as $card) {
          $word = $card->firstChild->nodeValue;
          $description = $card->childNodes->item(1)->nodeValue;
          DB::table('cards')->insert([
            'word'=>$word,
            'description'=>$description,
            'card_type_id'=>$id
          ]);
        }
      }

    }
}
