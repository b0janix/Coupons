<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessingTitle extends Model
{
protected $fillable=['title'];

public function construction_site() {
return $this->belongsTo(ConstructionSite::class);
  }
public function worker() {
return $this->belongsTo(Worker::class);
  }
public function coupon() {
return $this->belongsTo(Coupon::class);
  }

}
