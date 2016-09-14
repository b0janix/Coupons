<?php

namespace App\Services;

interface ForgotPasswordInterface {

public function sendHashedString($email, $hash);

}