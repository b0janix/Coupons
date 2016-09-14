@extends('Layouts.master')

@section('content')

{!!Form::open(array('route' =>'site.store'))!!}

{!!Form::label('name','Construction Site:')!!}<br/><br/>
{!!Form::text('name')!!}<br/><br/>
@if ($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif
{!!Form::submit('Add a construction site')!!}

{!!Form::close()!!}
<br>
<a href="{{ URL::previous() }}">Back</a>

@endsection