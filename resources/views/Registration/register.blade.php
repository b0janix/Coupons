@extends('Layouts.master')

@section('content')

<h1>Register</h1>

{!!Form::open(array('route' => 'register.store'))!!}

{!!Form::label('name','Your Name:')!!}
{!!Form::text('name')!!}
@if ($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif
<br/><br/>

{!!Form::label('email','Your Email:')!!}
{!!Form::email('email')!!}
@if ($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
<br/><br/>

{!!Form::label('password', 'Your Password:')!!}
{!!Form::password('password')!!}
@if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
<br/><br/>

{!!Form::label('password', 'Confirm Your Password:')!!}
{!!Form::password('password_confirmation')!!}
@if ($errors->has('password_confirmation')) <p>{{ $errors->first('password_confirmation') }}</p> @endif
<br/><br/>


{!!Form::submit('Create your account')!!}

{!!Form::close()!!}

@endsection
