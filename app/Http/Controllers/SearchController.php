<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\DistributionSearchServiceInterface;
use App\Services\ProcessingSearchServiceInterface;
use App\Services\AccessControlInterface;


class SearchController extends Controller
{

protected $dss;
protected $pss;
protected $ac;

function __construct(DistributionSearchServiceInterface $dss, ProcessingSearchServiceInterface $pss, AccessControlInterface $ac)  {
$this->ac=$ac;
$this->dss=$dss;
$this->pss=$pss;
$this->middleware('authenticate');
  }

public function presentDistributionForm(Request $request){
$this->ac->checkForPermission();
$result=$this->dss->fluentQuery($request);
return view('Search.distributions',compact('result'));
}

public function presentProcessingForm(Request $request){
$this->ac->checkForPermission();
$result=$this->pss->fluentQuery($request);
$sites=$this->pss->returnNeededSites();
return view('Search.processings',compact('result','sites'));
}

}
