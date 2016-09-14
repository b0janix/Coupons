<?php

namespace App\Services;

interface AdminPanelInterface  {
public function getEditorsNamesAndMails();
public function getRegularsNamesAndMails();
public function detachSelectedEditors($request);
public function attachSelectedUsers($request);
public function Admins();
}