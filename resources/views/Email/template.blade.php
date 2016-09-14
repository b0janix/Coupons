@extends('layouts.master')

@section('content')

<p>Click this link to reset your password:</p>
<?php//Here I'm creating a link that will take you to the reset.create route which expects the parameters email and identifier ?>
<a href="{!! route('reset.create', ['email'=>$email,'identifier'=>$identifier]) !!}">
Link</a>
@endsection