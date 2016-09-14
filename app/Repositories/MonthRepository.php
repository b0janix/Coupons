<?php

namespace App\Repositories;

use App\Month;

class MonthRepository implements MonthRepositoryInterface {

  protected $month;

function __construct(Month $month)  {
    $this->month=$month;
  }
//*
public function returnResult(){
return $this->month->orderBy('id','desc')->get();
}
//*
public function returnFirstResult(){
return $this->month->orderBy('id','desc')->first();
}
//*
public function insertTheInput($month){
$this->month->create(['month'=>$month]);
  }
//*
public function updateTheFirstRecord($month){
$update=$this->month->orderBy('id','desc')->first();
$update->update(['month'=>$month]);
  }
}