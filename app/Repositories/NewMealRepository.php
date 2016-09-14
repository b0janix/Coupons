<?php

namespace App\Repositories;

use App\NewMeal;

class NewMealRepository implements NewMealRepositoryInterface {

  protected $newMeal;

function __construct(NewMeal $newMeal)  {
    $this->newMeal=$newMeal;
  }

//*
public function DeleteNewMealRecord($cid,$wid){
$this->newMeal->where('coupon_id','=',$cid)->where('worker_id','=',$wid)->forceDelete();
}

public function getMealObjectByCoupId($id){
return $this->newMeal->where('coupon_id','=',$id)->first();
}

}