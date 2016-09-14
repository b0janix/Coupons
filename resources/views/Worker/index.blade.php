@extends('Layouts.master')

@section('content')

<h3>Workers who eat lunch at the hotel</h3>

<table>
  <thead>
    <trow>
      <th>Conto</th>
      <th>Name</th>
      <th>Department</th>
    </trow> 
@foreach($workers as $worker)
  <tbody>
    <trow>
      <td>{{$worker->accountNumber}}</td>
      <td><a href="/worker/{{$worker->id}}">{{$worker->workerName}}</a></td>
      <td>{{$worker->department->departmentName}}</td>
@endforeach
    </trow>
  </tbody>
</table>

<a href="/worker/create">Create a new worker</a>

@stop