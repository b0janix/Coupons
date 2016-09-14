<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
  protected $fillable=['departmentName'];

  public function workers()  {
    return $this->hasMany(Worker::class);
  }
}
