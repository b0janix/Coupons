@extends('Layouts.master')

@section('content')
<?php /*I'm using form model binding, and it means it will populate the form fields that have the same names as
model whose instance is passed in to model function*/?>
{!!Form::model($single, array('method'=>'PUT','route' => ['worker.update',$single->id]))!!}

{!!Form::label('accountNumber','Account Number:')!!}<br/><br/>
{!!Form::text('accountNumber')!!}<br/><br/>
@if ($errors->has('accountNumber')) <p>{{ $errors->first('accountNumber') }}</p> @endif

{!!Form::label('workerName','Name:')!!}<br/><br/>
{!!Form::text('workerName')!!}<br/><br/>
@if ($errors->has('workerName')) <p>{{ $errors->first('workerName') }}</p> @endif

{!!Form::label('departmentName','Departments')!!}
{!!Form::select('departmentName[]', $departments, $wordep)!!}

{!!Form::submit('Update a worker')!!}

{!!Form::close()!!}<br/>

{!!Form::open(array('method'=>'DELETE','route' => ['worker.destroy',$single->id]))!!}
{!!Form::submit('Delete a worker')!!}
{!!Form::close()!!}

@endsection