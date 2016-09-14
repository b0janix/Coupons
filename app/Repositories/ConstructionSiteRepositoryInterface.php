<?php

namespace App\Repositories;

interface ConstructionSiteRepositoryInterface {

public function findAllSites();

public function findSiteByName($site);

public function findSpecificSite($id);

public function saveSite($input);

public function updateSpecificSite($id, $input);

public function deleteSite($id);

public function findSiteByID($siteId);


}