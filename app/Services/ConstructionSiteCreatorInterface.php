<?php

namespace App\Services;

interface ConstructionSiteCreatorInterface {

public function showAllSites();

public function showSpecificSite($id);

public function createSite($request);

public function changeSiteName($id, $request);

public function destroySite($id);

}