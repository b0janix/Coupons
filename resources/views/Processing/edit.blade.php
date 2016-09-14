@extends('Layouts.master')

@section('content')

{!!Form::open(array('route' => 'plist.update'))!!}

{!!Form::select('month',['January'=>'January','February'=>'February','March'=>'March',
'April'=>'April','May'=>'May','June'=>'June','July'=>'July','August'=>'August',
'September'=>'September','October'=>'October','November'=>'November','December'=>'December'], $dateAndMeal[2],
['id'=>'monthEdit', 'placeholder' => 'Pick a month...'])
!!}

<br><br>

{!! Form::date('date',$dateAndMeal[0], array('id' => 'datepicker')) !!}
<br><br>
{!!Form::select('siteName', $siteNames, $site_name)!!}
<br><br>

{!! Form::select('meal',['breakfast'=>'breakfast','lunch'=>'lunch','supper'=>'supper'], $dateAndMeal[1], ['id'=>'meal']) !!}
<br><br>
<div class="form-edit">
@for($i=0;$i < count($array);$i++)

{!!Form::input('number','cn[]',$array[$i][0],['id'=>'cn'.$i,'class'=>'edit inputsC horizontal'.$i])!!}

{!!Form::input('number','an[]',$array[$i][1],['id'=>'an'.$i,'class'=>'edit inputsA horizontal'.$i])!!}

{!!Form::text('wn[]', $array[$i][2],['id'=>'wn'.$i,'class'=>'edit inputsW horizontal'.$i])!!}

{!! Form::image('images/Xbutton.png', 'btnImg', ['class' => 'horizontal'.$i]) !!}
<br>
@endfor
</div>
<br>
{!!Form::hidden('title',$title)!!}
{!!Form::hidden('string',$string)!!}
{!!Form::submit('Update',['id'=>'update'])!!}

{!!Form::close()!!}

<br>
<a href="{{ URL::previous() }}">Back</a>
@endsection