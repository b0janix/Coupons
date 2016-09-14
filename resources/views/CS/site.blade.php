@extends('layouts.master')

@section('content')

<h3>{{$cs->name}}</h3>

<a href="/site/{{$cs->id}}/edit">Edit</a>
<br><br>
{!!Form::open(['method'=>'GET','route' => 'site.index'])!!}
{!!Form::submit('Back')!!}
{!!Form::close()!!}

@endsection