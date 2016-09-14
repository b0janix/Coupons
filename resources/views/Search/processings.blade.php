@extends('Layouts.master')

@section('content')

{!!Form::open(['route' => 'present.processing'])!!}
<br>
{!!Form::select('month',['January'=>'January','February'=>'February','March'=>'March',
'April'=>'April','May'=>'May','June'=>'June','July'=>'July','August'=>'August',
'September'=>'September','October'=>'October','November'=>'November','December'=>'December'], null,
['placeholder' => 'Pick a month...'])
!!}
<br><br>
{!! Form::date('date',null,['id'=>'calendar']) !!}
<br><br>
{!! Form::label('from','From:') !!}
<br>
{!! Form::date('from',null,['id'=>'from']) !!}
<br><br>
{!! Form::label('to','To:') !!}
<br>
{!! Form::date('to',null,['id'=>'to']) !!}
<br><br>
{!! Form::select('site', $sites,null,['placeholder' => 'Pick a site...']) !!}
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
@if($result!=false)
@for($i=0;$i < count($result[0]);$i++)
<div class="present-results">
{{$result[0][$i][0]}} {{$result[0][$i][1]}} {{$result[0][$i][2]}} {{$result[3][$i]}} {{$result[1][$i]}} {{$result[0][$i][5]}} 
{{$result[0][$i][6]}} {{$result[2][$i]}}
</div>
@endfor
@endif
@if($result==false)
<p>There are no results for the provided parameters.</p>
@endif
<br>
<a href="{{ URL::previous() }}">Back</a>
@endsection