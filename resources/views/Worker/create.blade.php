@extends('Layouts.master')

@section('content')

{!!Form::open(array('route' => 'worker.store'))!!}

{!!Form::label('accountNumber','Account Number:')!!}<br/><br/>
{!!Form::text('accountNumber')!!}<br/><br/>
@if ($errors->has('accountNumber')) <p>{{ $errors->first('accountNumber') }}</p> @endif

{!!Form::label('workerName','Name:')!!}<br/><br/>
{!!Form::text('workerName')!!}<br/><br/>
@if ($errors->has('workerName')) <p>{{ $errors->first('workerName') }}</p> @endif

{!!Form::label('departmentName','Departments:')!!}
{!!Form::select('departmentName[]', $departments, null)!!}

{!!Form::submit('Add a new worker')!!}

{!!Form::close()!!}
<br>
<a href="{{ URL::previous() }}">Back</a>
@endsection