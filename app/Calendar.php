<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
protected $fillable=['month','date'];

 public function construction_site()  {
  return $this->belongsTo(ConstructionSite::class);
  }

public function coupon()  {
  return $this->belongsTo(Coupon::class);
  }

public function worker()  {
  return $this->belongsTo(Worker::class);
  }

}
