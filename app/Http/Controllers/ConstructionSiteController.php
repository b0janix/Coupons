<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ConstructionSiteCreatorInterface;
use App\Services\AccessControlInterface;
use App\Validators\SiteValidator;

class ConstructionSiteController extends Controller
{

protected $creator;
protected $ac;

function __construct(ConstructionSiteCreatorInterface $creator, AccessControlInterface $ac) {

$this->creator=$creator;
$this->ac=$ac;
$this->middleware('authenticate');

}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$this->ac->checkForPermission();
$sites=$this->creator->showAllSites();
return view('CS.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
$this->ac->checkForPermission();
return view('CS.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SiteValidator $v)
    {

$validator= $v->validateSiteCreation($request);
if ($validator->fails()) {
return redirect()->route('site.create')
->withErrors($validator)
->withInput();
  }

$this->creator->createSite($request);
return redirect()->route('site.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
$this->ac->checkForPermission();
$cs=$this->creator->showSpecificSite($id);
return view('CS.site', compact('cs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
$this->ac->checkForPermission();
$cs=$this->creator->showSpecificSite($id);
return view('CS.edit', compact('cs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, SiteValidator $v)
    {
$validator= $v->validateSiteCreation($request);
if ($validator->fails()) {
return redirect()->route('site.edit')
->withErrors($validator)
->withInput();
  }
$this->creator->changeSiteName($id, $request);
return redirect()->route('site.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
return $this->creator->destroySite($id);
    }
}
