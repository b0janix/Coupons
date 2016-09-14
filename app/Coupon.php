<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Worker;
use App\Title;

class Coupon extends Model
{
protected $fillable=['coupon_number'];

public function workers() {
return $this->belongsToMany(Worker::class)->withPivot('year','month','date','meal','title');
  }

public function processing_titles()  {
    return $this->hasMany(ProcessingTitle::class);
  }

public function new_meals()  {
    return $this->hasMany(NewMeal::class);
  }

public function calendars()  {
    return $this->hasMany(Calendar::class);
  }

}
