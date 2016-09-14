<?php

namespace App\Services;

use App\Validators\SiteValidator;
use App\Repositories\ConstructionSiteRepositoryInterface;

class ConstructionSiteCreator implements ConstructionSiteCreatorInterface {

protected $v;
protected $site_repository;

function __construct(SiteValidator $v, ConstructionSiteRepositoryInterface $site_repository){

$this->v=$v;
$this->site_repository=$site_repository;

  }
//*
public function showAllSites()  {

return $this->site_repository->findAllSites();

  }
//*
public function showSpecificSite($id) {

return $this->site_repository->findSpecificSite($id);

  }
//*
public function createSite($request)  {

$this->site_repository->saveSite(['name'=>$request->input('name')]);

  }
//*
public function changeSiteName($id, $request)  {

$this->site_repository->updateSpecificSite($id, ['name'=>$request->input('name')]);

  }
//*
public function destroySite($id)  {
  $this->site->deleteSite($id);
  return redirect()->route('site.index');
   }

}