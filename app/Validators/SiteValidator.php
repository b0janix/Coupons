<?php

namespace App\Validators;

use Validator;

class SiteValidator {

public function validate($data){

  return Validator::make($data, ['name' => 'required|min:3',]);
  }

public function validateSiteCreation($request){
$validator=$this->validate($request->only(['name']));
if ($validator->fails()) {
return $validator;
  }
}

}