<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstructionSite extends Model
{
    //
  protected $fillable = ['name'];

public function processing_titles() {
return $this->hasMany(ProcessingTitle::class);
  }

public function new_meals()  {
    return $this->hasMany(NewMeal::class);
  }

public function calendars()  {
    return $this->hasMany(Calendar::class);
  }


}
