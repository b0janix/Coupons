<?php

namespace App\Services;

interface ResetPasswordInterface  {

public function verifyToken($email, $identifier, $hash);

public function changeThePassword($request, $hash);



}