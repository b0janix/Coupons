<?php

namespace App\Repositories;

use App\ConstructionSite;

class ConstructionSiteRepository implements ConstructionSiteRepositoryInterface {

protected $site;

function  __construct(ConstructionSite $site)  {

$this->site=$site;

}

//*
public function findAllSites()  {

return $this->site->where('name','!=','No lunch')->get();

  }
//*
public function findSiteByName($site){
return $this->site->where('name','=',$site)->first();
}
//*
public function findSpecificSite($id) {

return $this->site->where('id','=',$id)->first();

  }
//*
public function saveSite($input)  {

$this->site->create($input);

}
//*
public function updateSpecificSite($id, $input) {

$s= $this->site->where('id','=',$id)->first();
$s->update($input);

  }
//*
public function deleteSite($id) {
$delete=$this->site->findOrFail($id);
$delete->forceDelete();
  }
//*
public function findSiteByID($siteId){
return $this->site->where('id','=',$siteId)->first();
}

/*
public function returnPivots($dateSite){
return $this->site->with('workers')->join('construction_site_worker', 'construction_sites.id','=','construction_site_worker.construction_site_id')->where('construction_site_worker.title','LIKE',$dateSite.'%')
->where('construction_site_worker.title','LIKE','%lunch')->select('construction_site_worker.*')->get();
}

public function returnPivotsC($dateSite){
return $this->site->join('construction_site_coupon', 'construction_sites.id','=','construction_site_coupon.construction_site_id')->where('construction_site_coupon.title','LIKE',$dateSite.'%')
->where('construction_site_coupon.title','LIKE','%lunch')->select('construction_site_coupon.*')->get();
}

public function returnWorkerIdsByTitle($title){
return $this->site->join('construction_site_worker', 'construction_sites.id','=','construction_site_worker.construction_site_id')->where('construction_site_worker.title','=',$title)->select('construction_site_worker.worker_id')->get();
}

public function returnCouponIdsByTitle($title){
return $this->site->join('construction_site_coupon', 'construction_sites.id','=','construction_site_coupon.construction_site_id')->where('construction_site_coupon.title','=',$title)->select('construction_site_coupon.coupon_id')->get();
}

public function returnSiteByTitle($title){
return $this->site->with('coupons','workers')->join('construction_site_coupon', 'construction_sites.id','=','construction_site_coupon.construction_site_id')->where('construction_site_coupon.title','=',$title)->first();
}

public function findSiteByTitleC($title){
return $this->site->join('construction_site_coupon', 'construction_sites.id','=','construction_site_coupon.construction_site_id')->where('construction_site_coupon.title','=',$title)->first();}

public function findSiteByTitleW($title){
return $this->site->join('construction_site_worker', 'construction_sites.id','=','construction_site_worker.construction_site_id')->where('construction_site_worker.title','=',$title)->first();}*/

}

