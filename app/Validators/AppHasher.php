<?php
namespace App\Validators;

use Hash;

class AppHasher  {
//*
public function hashing($input) {
return Hash::make($input);
  }

public function hashChecking($input, $db)  {
return Hash::check($input, $db);
  }
  
}