@extends('Layouts.master')

@section('content')
<?php//if the array of titles is empty return the paragraph bellow?>
@if(count($array)==0)
<p>There are no coupons distributed at all.</p>
@endif

@foreach ($array as $member)
<?php //I'm passing the title as an URL parameter to every title link?>
<a href="{!! route('dlist', ['title'=>$member])!!}">
{{$member}}
</a><br>
@endforeach
<br>
{{ Form::open(['route' => 'distribute.create', 'method' => 'GET'])}}
{!!Form::submit('Distribute coupons')!!}
{{ Form::close() }}
@endsection

