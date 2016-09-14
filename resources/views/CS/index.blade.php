@extends('Layouts.master')

@section('content')

<h1>List of all construction sites</h1>
@foreach($sites as $site)
<ul><li><a href="/site/{{$site->id}}">{{$site->name}}</a></li></ul>
@endforeach
<br>
{!!Form::open(['method'=>'GET','route' => 'site.create'])!!}
{!!Form::submit('Create a new construction site')!!}
{!!Form::close()!!}

@endsection