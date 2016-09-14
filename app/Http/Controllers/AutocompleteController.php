<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\AutocompleteServiceInterface;


class AutocompleteController extends Controller
{
protected $autocomplete;

function __construct(AutocompleteServiceInterface $autocomplete) {

$this->autocomplete=$autocomplete;

  }


public function autocompleteAction(Request $request)  {
//Calls another method from the autocomplete service to which it passes the term parameter
return $this->autocomplete->searchWorker($request->input('term'));

  }

public function storeMonthMeal(Request $request) {
$this->autocomplete->storeMonthMeal($request);
return $request->all();
}

public function autocompleteCouponAction(Request $request){
return $this->autocomplete->returnCouponWithWorker($request->input('term'));
  }

public function autocompleteEditCouponAction(Request $request){
return $this->autocomplete->editCouponWithWorker($request->input('term'));
  }

public function autocompleteNameAction(Request $request){
return $this->autocomplete->returnNameOfWorker($request->input('term'));
  }
/*this is the method from the autocomplete controller that checks whether the data entered 
in distributionCreate view already exists in the database*/
public function distributionDuplicate(Request $request){
return $this->autocomplete->returnIfDistributionDuplicate($request);
}
/*this is the method from the autocomplete controller that checks whether the data entered 
in Processing.create and Processing.edit views already exists in the database*/
public function processingDuplicate(Request $request){
return $this->autocomplete->returnIfProcessingDuplicate($request);
}

}
