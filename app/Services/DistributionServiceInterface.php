<?php

namespace App\Services;

interface DistributionServiceInterface  {

public function saveDistributionInputs($request);

public function returnTitle();

public function returnWantedCoupons($title);

public function verifyBeforeDeleting($request);

public function returnTheSelectedCouponsAndWorkers($array);

public function destroy($id);

}