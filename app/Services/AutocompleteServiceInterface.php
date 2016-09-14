<?php

namespace App\Services;

interface AutocompleteServiceInterface  {

public function searchWorker($term);
public function storeMonthMeal($request);
public function returnCouponWithWorker($term);
public function returnIfDistributionDuplicate($request);
public function returnIfProcessingDuplicate($request);
public function returnNameOfWorker($term);

}