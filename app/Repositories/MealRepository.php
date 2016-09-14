<?php

namespace App\Repositories;

use App\Meal;

class MealRepository implements MealRepositoryInterface {

  protected $meal;

function __construct(Meal $meal)  {
    $this->meal=$meal;
  }
//*
public function returnResult(){
return $this->meal->orderBy('id','desc')->get();
}
//*
public function returnFirstResult(){
return $this->meal->orderBy('id','desc')->first();
}
//*
public function insertTheInput($meal){
$this->meal->create(['meal'=>$meal]);
  }
//*
public function updateTheFirstRecord($meal){
$update=$this->meal->orderBy('id','desc')->first();
$update->update(['meal'=>$meal]);
  }
}