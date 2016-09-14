<?php

namespace App\Repositories;

interface MealRepositoryInterface {

public function returnResult();
public function returnFirstResult();
public function insertTheInput($meal);
public function updateTheFirstRecord($meal);

}