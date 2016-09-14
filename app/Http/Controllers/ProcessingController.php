<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ProcessingServiceInterface;
use App\Services\AccessControlInterface;
use App\Validators\CouponDistributionValidator;

class ProcessingController extends Controller {

protected $ps;
protected $ac;

function __construct(ProcessingServiceInterface $ps, AccessControlInterface $ac)  {
$this->ac=$ac;
$this->ps=$ps;
$this->middleware('authenticate');
  }


public function index() {
$this->ac->checkForPermission();
$titles=$this->ps->returnTitles();
return view('Processing.index',compact('titles'));
  }

public function create() {
$this->ac->checkForPermission();
$sites=$this->ps->getTheSites();
foreach($sites as $site){
$siteNames[]=$site->name;
}
//I'm creating an array that has the construction site names as keyes and values
/*If the array containing the construction site names is index based array than the site names would have been saved in the database as numbers*/ 
$siteNames=array_combine(array_values($siteNames),array_values($siteNames));
return view('Processing.create', compact('siteNames'));
  }

public function createBD() {
$this->ac->checkForPermission();
return view('Processing.createBD');
  }

public function store(Request $request, CouponDistributionValidator $v) {
$validator=$v->validateDistributionCreation($request);

if($validator!=[])
{
return redirect()->route('process.create')
->withErrors($validator)
->withInput();
}
$this->ps->attachDataToConstructionSite($request);
return redirect()->route('process.index');
  }

  public function storeBD(Request $request, CouponDistributionValidator $v) {
$validator=$v->validateDistributionCreation($request);
if($validator!=[])
{
return redirect()->route('process.createbd')
->withErrors($validator)
->withInput();
}
$this->ps->attachNonLunchDataToConstructionSite($request);
return redirect()->route('process.index');
  }

public function showPlist($title){
$this->ac->checkForPermission();
$array=$this->ps->returnCouponsAndWorkersAttachedToTitle($title);
return view('Processing.plist',compact('array','title'));
  }

public function storePlist(Request $request){
$this->ps->detachDataFromConstructionSite($request);
return redirect()->route('process.index');
  }

public function edit(Request $request){
$this->ac->checkForPermission();
$array=$this->ps->processEditData($request);
$string=$this->ps->transformArrayToString($array);
$dateAndMeal=$this->ps->returnDateAndMeal($request);
$sites=$this->ps->getTheSites();
$title=$request->input('title');
$site_name=explode(" ",$title)[1];
foreach($sites as $site){
$siteNames[]=$site->name;
}
$siteNames=array_combine(array_values($siteNames),array_values($siteNames));
return view('Processing.edit',compact('array','dateAndMeal','siteNames','title','string','site_name'));
}

public function update(Request $request){

$this->ps->updateWithSubmitedData($request);
return redirect()->route('process.index');
}

}
