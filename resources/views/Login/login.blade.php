@extends('Layouts.master')

@section('content')

<h1>Sign in</h1>

{!!Form::open(array('route' => 'login.store'))!!}

{!!Form::label('email','Your Email:')!!}
{!!Form::email('email')!!}
@if ($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
<br/><br/>

{!!Form::label('password', 'Your Password:')!!}
{!!Form::password('password')!!}
@if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
<br/><br/>
{!!Form::submit('Login')!!}
<br/><br/>
{!!Form::close()!!}

<a href="/register">Register</a><br/>
<a href="/fp">Forgot your password?</a>

@if (session()->has('flash_message'))

{{session()->get('flash_message')}}

@endif

@endsection
