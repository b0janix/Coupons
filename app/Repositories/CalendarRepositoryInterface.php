<?php

namespace App\Repositories;

interface CalendarRepositoryInterface {
public function returnCalendarObjects($date,$month);
public function DeleteCalendarRecord($cid,$wid);
}