@extends('Layouts.master')

@section('content')

{!!Form::open(['route' => 'process.store'])!!}

{!!Form::select('month',['January'=>'January','February'=>'February','March'=>'March',
'April'=>'April','May'=>'May','June'=>'June','July'=>'July','August'=>'August',
'September'=>'September','October'=>'October','November'=>'November','December'=>'December'], null,
['id'=>'month', 'placeholder' => 'Pick a month...'])
!!}

<br><br>

{!! Form::date('date',\Carbon\Carbon::now(), array('id' => 'datepicker')) !!}
<br><br>
{!!Form::select('siteName', $siteNames, null,['id'=>'siteName'])!!}
<br><br>
{!! Form::text('meal', 'lunch',['id'=>'meal']) !!}
<br><br>

<h4>Coupon Number&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Account Number&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Worker Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
Department</h4> 


<div class="form-row">
</div>
<br><br>
@if (isset($errors) and count($errors) > 0)
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif
{!!Form::button('Add more fields',['id'=>'process', 'class'=>'button'])!!}
{!!Form::hidden('secret','',['id'=>'secret'])!!}
{!!Form::hidden('year',date('Y'),['id'=>'year'])!!}
<br><br>
{!!Form::submit('Submit',['class'=>'submit'])!!}

{!!Form::close()!!}
<br>
<a href="{{ URL::previous() }}">Back</a>

@endsection