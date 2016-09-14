@extends('Layouts.master')

@section('content')

{!!Form::open(['route' => 'present.distribution'])!!}
<br>
{!!Form::text('year',date('Y'),['id'=>'year'])!!}
<br><br>
{!!Form::select('month',['January'=>'January','February'=>'February','March'=>'March',
'April'=>'April','May'=>'May','June'=>'June','July'=>'July','August'=>'August',
'September'=>'September','October'=>'October','November'=>'November','December'=>'December'], null,
['placeholder' => 'Pick a month...'])
!!}
<br><br>
{!! Form::select('meal', ['breakfast'=>'breakfast','lunch'=>'lunch','supper'=>'supper'],null,['placeholder' => 'Pick a meal...']) !!}
<br><br>
<h4>Coupon Number&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Account Number&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Worker Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Department</h4> 
{!! Form::input('number', 'couponNumber') !!}
{!! Form::input('number', 'accountNumber') !!}
{!! Form::text('workerName',null,['id'=>'wname']) !!}
{!!Form::select('department',['Visokogradba'=>'Visokogradba','Niskogradba'=>'Niskogradba','Mehanizacija'=>'Mehanizacija',
'Laboratorija'=>'Laboratorija','Gamatroniks'=>'Gamatroniks','Direkcija'=>'Direkcija','Komercija'=>'Komercija','Ugostitelska Dejnost'=>'Ugostitelska Dejnost'], null,['placeholder' => 'Pick a department...'])!!}
{!!Form::submit('Search')!!}
{!!Form::close()!!}
<br>
@if(count($result[0])>0)
@for($i=0;$i < count($result[0]);$i++)
<div class="present-results">
{{$result[0][$i]->year}} {{$result[0][$i]->month}} {{$result[0][$i]->meal}} {{$result[1][$i]}} {{$result[0][$i]->accountNumber}} 
{{$result[0][$i]->workerName}} {{$result[2][$i]}} 
</div>
@endfor
@endif
@if(count($result[0])==0)
<p>There are no results for the provided parameters.</p>
@endif
<br>
<a href="{{ URL::previous() }}">Back</a>
@endsection