@extends('layouts.master')

@section('content')

<h1>Well hello {{$single->workerName}}, how you doin?</h1>

Your account number is {{$single->accountNumber}} and your department is {{$single->department->departmentName}}.<br/><br/>

<a href="/worker/{{$single->id}}/edit">Edit a worker</a>

@endsection