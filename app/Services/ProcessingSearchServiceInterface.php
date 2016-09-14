<?php

namespace App\Services;

interface ProcessingSearchServiceInterface {
public function fluentQuery($request);
public function returnNeededSites();
}