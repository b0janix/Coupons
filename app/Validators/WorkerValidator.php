<?php

namespace App\Validators;

use Validator;

class WorkerValidator {

  public function validate($data){
//The first argument is an array of the needed data, it must be an array, the second argument is an array of rules
return  Validator::make($data, [
  'workerName' => 'required|alpha|min:3',
  'accountNumber'=>'required|numeric',
    ]);
  }
//*
public function validateWorkerCreation($request){
//This method calls other method validate that actually executes the manual validation using Laravel's Validator facade 
$validator=$this->validate($request->only(['accountNumber','workerName']));
if ($validator->fails()) {
return $validator;
  }
}

}