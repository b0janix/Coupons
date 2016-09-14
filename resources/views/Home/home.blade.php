@extends('layouts.master')

@section('content')

<?php//only uder with editor role can view theese links ?>
@can('allow',$editor)
<a href="{!! route('worker.create') !!}">Create Worker</a>
<a href="{!! route('site.create') !!}">Create Construction Site</a>
<a href="{!! route('distribute.create') !!}">Distribute the coupons</a>
<a href="{!! route('process.create') !!}">Process the coupons</a>
<a href="{!! route('present.distribution') !!}">Show distirbution data</a>
<a href="{!! route('present.processing') !!}">Show processing data</a>
@endcan 
<h3>This is the home page</h3>

@if(session()->has('global'))
{{session()->get('global')}}
@endif

@if (Auth::guest())
<li><a href="/login">Login</a></li>
@else
<a href="/logout">Logout</a>
@endif
<br><br>
<?php//only user with admin role can view theese links ?>
@can('manage',$admin)
<a href="{!! route('panel') !!}">Manage users</a>
@endcan 
@endsection