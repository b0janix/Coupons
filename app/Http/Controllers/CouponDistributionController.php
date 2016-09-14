<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\DistributionServiceInterface;
use App\Services\AccessControlInterface;
use App\Validators\CouponDistributionValidator;

class CouponDistributionController extends Controller
{
  protected $ds;
  protected $ac;

function __construct(DistributionServiceInterface $ds, AccessControlInterface $ac)  {
$this->ds=$ds;
$this->ac=$ac;
//Checks whether visitor is authenticated
$this->middleware('authenticate');
  }

    public function index()
    {
//Calls a method that checks whether user has an editor permission
$this->ac->checkForPermission();
/*Returns an array of nonduplicate titles which are string links that contain: 
the name of the month for which they are distributed among workers, the date when they were distributed 
and the meal (breakfast, lunch, supper/dinner)*/
$array=$this->ds->returnTitle();
return view('Coupons.index', compact('array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//Calls a method that checks whether user has an editor permission
$this->ac->checkForPermission();
return view('Coupons.distributionCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CouponDistributionValidator $v)
    {
$validator=$v->validateDistributionCreation($request);
if($validator)
{
return redirect()->route('distribute.create')
->withErrors($validator)
->withInput();
}
 $this->ds->saveDistributionInputs($request);
return redirect()->route('distribute.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//I'm fetching the title parameter which I've passed in the index view to every title link
    public function showDlist($title)
    {
//Calls a method that checks whether user has an editor permission
$this->ac->checkForPermission();
//Returns the coupons that have a foreign key in a coupon_worker table and a title equal to the one passed
$coupons=$this->ds->returnWantedCoupons($title);
//Returns the workers that have a foreign key in a coupon_worker table and a title equal to the one passed
$workers=$this->ds->returnWantedWorkers($title);
$title=explode(" ",$title);
//The first and the last item in the title array are the name of the month and the meal for which the coupons were distributed
$meal=end($title);
$month=reset($title);
return view('Coupons.dlist', compact('coupons','workers','meal','month'));
    }

            /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifyDlist(Request $request)
    {
//should return those workers(names, coup. numbers, account numbers) that have checked boxes, as an array
$array=$this->ds->verifyBeforeDeleting($request);
//if the session with a session name array is set
if($request->session()->has('array',$array)){
//destroy the session
$request->session()->forget('array');
//start a new session with a session name array, and set the array of coupon ids as a session value
$request->session()->put('array', $array);
//redirect the request to the dlist.terminate rote
return redirect()->route('dlist.terminate');}
//if the session was not set, set the session and redirect to the dlist.terminate route
$request->session()->put('array',$array);
return redirect()->route('dlist.terminate');
    }

 public function terminate(Request $request)
    {
//Calls a method that checks whether user has an editor permission
$this->ac->checkForPermission();
//retrieves the session value from the array session
$array=session('array');
$checkBox=$this->ds->returnTheSelectedCouponsAndWorkers($array);
$string=$checkBox[0];
$checkBoxOne=$checkBox[1];
return view('Coupons.terminate', compact('string','checkBoxOne'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //fetch the string of ids
    public function destroy($string)
    {
//calls a method of the distribution service
$this->ds->destroy($string);
return redirect()->route('distribute.index');
    }
}
