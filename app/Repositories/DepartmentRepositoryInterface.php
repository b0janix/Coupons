<?php

namespace App\Repositories;

interface DepartmentRepositoryInterface {

public function showAllDepartments();
public function findDepartment($input_d);
public function findDepartmentByName($name);
public function findDepartmentById($id);

}