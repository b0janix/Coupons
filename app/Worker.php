<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coupon;

class Worker extends Model
{
    //
  protected $fillable=['workerName','accountNumber'];

  public function department()  {
  return $this->belongsTo(Department::class);
  }

  public function coupons() {
  return $this->belongsToMany(Coupon::class)->withPivot('year','month','date','meal','title');
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