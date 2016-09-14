<?php
namespace App\Repositories;

use App\Repositories\DepartmentRepositoryInterface;
use App\Department;

class DepartmentRepository implements DepartmentRepositoryInterface {

protected $department;

  function __construct(Department $department)  {
    $this->department=$department;
  }
//*
  public function showAllDepartments()  {
//It will return an array of key-value pairs for the departmentName field, with ids as keyes
  return  $this->department->pluck('departmentName','id');

  }
//*
  public function findDepartment($input_d)  {
//The request method will return the id of the department because in the pluck method we've set the key to be the id
  return  $this->department->where('id','=',$input_d)->first();

  }
//*
  public function findDepartmentByName($name){
return $this->department->where('departmentName','=',$name)->first();
  }

//*
public function findDepartmentById($id){
return $this->department->where('id','=',$id)->first();
}

}