@extends('layouts.master')

@section('content')

<h2>Recover your password</h2>

{!!Form::open(array('route' => 'fp.store'))!!}

{!!Form::label('email','Your Email:')!!}
{!!Form::email('email')!!}
@if ($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
<br/><br/>

{!!Form::submit('Apply for new password')!!}<br/>

{!!Form::close()!!}

@if (session()->has('message'))
  {{session()->get('message')}}
@elseif (session()->has('the_message')) 
  {{session()->get('the_message')}}

@endif

@endsection