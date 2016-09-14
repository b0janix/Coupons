<?php

namespace App\Repositories;

interface RoleRepositoryInterface {
public function findEditorRole();
public function returnEditorsUserIds();
public function findAdminRole();
}