<?php

namespace App\Services;

interface AccessControlInterface  {
public function checkForPermission();
public function checkForAdminPermission();
}