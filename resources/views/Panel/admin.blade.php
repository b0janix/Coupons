@extends('layouts.master')

@section('content')

List of editors:
<br>
@if(count($array[0])==0 and count($array[1])==0)
There are no active editors at this moment.
@else
@for($i=0;$i < count($array[0]);$i++)
{{Form::checkbox('editors',null,null,['id'=>'editors'.$i,'class'=>'editors'])}}<br>
<div class=<?php echo "editors"?> id=<?php echo "editors".$i ?>>{{$array[0][$i]}} {{$array[1][$i]}}</div><br>
@endfor
@endif

{!!Form::open(array('route' => 'dismissions'))!!}
{!!Form::hidden('secret','',['class'=>'secret_two'])!!}
{!!Form::submit('Dismiss editors',['id'=>'dismiss'])!!}
{!!Form::close()!!}
<br>
List of users without any permissions:
<br><br>
@if(count($regulars[0])==0 and count($regulars[1])==0)
There are no permissionless users at this moment.<br><br>
@else
@for($i=0;$i < count($regulars[0]);$i++)
{{Form::checkbox('regulars',null,null,['id'=>'regulars'.$i,'class'=>'regulars'])}}<br>
<div class=<?php echo "regulars"?> id=<?php echo "regulars".$i ?>>{{$regulars[0][$i]}} {{$regulars[1][$i]}}</div><br>
@endfor
@endif

{!!Form::open(array('route' => 'additions'))!!}
{!!Form::hidden('hidden','',['class'=>'secret_three'])!!}
{!!Form::submit('Make them editors',['id'=>'add'])!!}
{!!Form::close()!!}

<br>
List of admins:
<br><br>
@for($i=0;$i < count($admins[0]);$i++)
<div class=<?php echo "admins"?>>{{$admins[0][$i]}} {{$admins[1][$i]}}</div><br>
@endfor
<br>
{!!Form::open(['method'=>'GET','route' => 'home'])!!}
{!!Form::submit('Back')!!}
{!!Form::close()!!}

@endsection