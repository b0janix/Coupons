<?php

namespace App\Services;

interface WorkerGeneratorInterface  {
public function showAllWorkers();
public function listAllDepartments();
public function generateWorkers($request);
public function showSingleWorker($id);
public function theDepartmentsId($id);
public function updateWorker($id, $request);
public function destroyWorker($id);
}