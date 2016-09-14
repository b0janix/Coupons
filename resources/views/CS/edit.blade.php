@extends('Layouts.master')

@section('content')

{!!Form::model($cs, array('method'=>'PUT','route' => ['site.update',$cs->id]))!!}

{!!Form::label('name','Construction Site:')!!}<br/><br/>
{!!Form::text('name')!!}<br/><br/>
@if ($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif

{!!Form::submit('Edit')!!}

{!!Form::close()!!}<br/>

{!!Form::open(array('method'=>'DELETE','route' => ['site.destroy',$cs->id]))!!}
{!!Form::submit('Delete')!!}
{!!Form::close()!!}

@endsection