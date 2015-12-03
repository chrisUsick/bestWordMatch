<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
  protected $fillable = array('type');

  public function cards()
  {
    return $this->hasMany('App\Card');
  }
}
