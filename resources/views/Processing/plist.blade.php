@extends('Layouts.master')
@section('content')
@if(count($array)==0)
There are no coupons used on this construction site on this date.
@endif
@if(is_array($array[0])==true and is_array($array[1])==true and is_array($array[2])==true)
@if(count($array[0])==count($array[1]) and count($array[0])==count($array[2]))
@for($i=0;$i < count($array[0]);$i++)
{{Form::checkbox('rb',null,null,['class'=>'results', 'id'=>'results'.$i])}}<br>
<div class=<?php echo "results"?> id=<?php echo "results".$i?>>{{$array[0][$i]}} {{$array[1][$i]}} {{$array[2][$i]}} {{$array[3][$i]}}</div>
@endfor
@endif
@endif
<br><br>
{!!Form::open(array('route' => 'plist.store'))!!}
{!!Form::hidden('secret','',['class'=>'secret_one'])!!}
{!!Form::hidden('title',$title)!!}
{!!Form::submit('Detach',['id'=>'detach'])!!}
{!!Form::close()!!}
<br>
{!!Form::open(array('route' => 'plist.edit'))!!}
{!!Form::hidden('secret','',['class'=>'secret_one'])!!}
{!!Form::hidden('title',$title)!!}
{!!Form::submit('Edit',['id'=>'edit'])!!}
{!!Form::close()!!}
<br>
{{ Form::open(['route' => 'process.index', 'method' => 'GET'])}}
{!!Form::submit('Back')!!}
{{ Form::close() }}
@endsection