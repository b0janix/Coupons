<?php

namespace App\Repositories;

interface WorkerRepositoryInterface {
public function workersAndDepartments();
public function createWorkers($input, $dbdep);
public function findSingleWorker($id);
public function workersDepartment($id);
public function changeWorker($id, $input, $dbdep);
public function deleteWorker($id);
public function returnWorkersId($inputAccount, $inputName);
public function returnWorkersWithCoupons();
public function findWorkerById($id);
public function findCouponId($id,$date,$meal);
public function findWorkerByNumber($term);
public function  findWorkerByNumberFiltered($number, $month, $meal);
public function findWorkerByName($term);
public function returnWorker($inputAccount, $inputName);
}