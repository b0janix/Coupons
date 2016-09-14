<?php

namespace App\Services;

use App\Repositories\RoleRepositoryInterface;

class HomeService implements HomeServiceInterface {

protected $role_repository;

function __construct(RoleRepositoryInterface $role_repository)  {
$this->role_repository=$role_repository;
}

public function retrieveEditorObject(){
return $this->role_repository->findEditorRole();
}

public function retrieveAdminObject(){
return $this->role_repository->findAdminRole();
}

}