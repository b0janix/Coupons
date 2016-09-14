<?php

namespace App\Services;

interface UserAuthenticatorInterface  {
  public function registerUsers($hash, $register);
  public function loginUsers($request);
  public function logoutUsers();
  }