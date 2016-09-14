<?php

namespace App\Repositories;

interface ProcessingTitleRepositoryInterface {
public function returnTitles();
public function returnTitleRecord($title);
public function returnTitleByIdsAndLunch($meal,$workerId, $couponId);
public function DeleteTitleRecord($cid,$wid);
}