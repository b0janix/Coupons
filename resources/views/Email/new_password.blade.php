@extends('layouts.master')

@section('content')

<h1>Register a new password</h1>

{!!Form::open(array('route' => 'reset.store'))!!}
{!!Form::label('password', 'Your Password:')!!}
{!!Form::password('password')!!}
@if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif


<br/><br/>

{!!Form::label('password', 'Confirm Your Password:')!!}
{!!Form::password('password_confirmation')!!}
@if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
<?php//place them into hidden inputs and send them to the reset.store route for further proccessing ?>
{!!Form::hidden('email', $email)!!}
{!!Form::hidden('identifier', $identifier)!!}

<br/><br/>

{!!Form::submit('Add new password')!!}<br/>

{!!Form::close()!!}

<br/><br/>

@if (session()->has('message'))
  {{session()->get('message')}}
@elseif (session()->has('message_one')) 
  {{session()->get('message_one')}}
@elseif (session()->has('message_two')) 
  {{session()->get('message_two')}}
@endif


@endsection