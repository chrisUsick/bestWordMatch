<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
  protected $fillable = ['word', 'description'];

  public function type () {
    return $this->belongsTo('App\CardType', 'card_type_id');
  }
}
