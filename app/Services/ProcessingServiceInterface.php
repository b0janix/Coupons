<?php

namespace App\Services;

interface ProcessingServiceInterface  {
public function getTheSites();
public function attachDataToConstructionSite($request);
public function returnTitles();
public function attachNonLunchDataToConstructionSite($request);
public function returnCouponsAndWorkersAttachedToTitle($title);
public function detachDataFromConstructionSite($request);
public function processEditData($request);
public function transformArrayToString($array);
public function returnDateAndMeal($request);
public function updateWithSubmitedData($request);
}