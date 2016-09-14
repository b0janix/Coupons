<?php

namespace App\Validators;

use Validator;

class ResetValidator {
//*
public function validate($data){

  return Validator::make($data, ['email' => 'required|email']);

  }
//*
public function validateUser($request){
$data=$request->only(['email']);

$validator=$this->validate($data);
if (count($validator->invalid())>0) {
return $validator;
        }
return[];
}

}