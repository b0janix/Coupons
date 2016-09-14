<?php

namespace App\Repositories;

interface MonthRepositoryInterface {

public function returnResult();
public function returnFirstResult();
public function insertTheInput($month);
public function updateTheFirstRecord($month);

}