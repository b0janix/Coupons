@extends('Layouts.master')

@section('content')

@if(count($titles)==0)
<p>There is no coupon data processed yet.</p>
@endif

@foreach ($titles as $title)
<a href="{!! route('plist', ['title'=>$title]) !!}">
{{$title}}
</a><br>
@endforeach
<br>
{{ Form::open(['route' => 'process.create', 'method' => 'GET'])}}
{!!Form::submit('Process lunch coupons')!!}
{{ Form::close() }}
<br>
{{ Form::open(['route' => 'process.createbd', 'method' => 'GET'])}}
{!!Form::submit('Process breakfast or supper coupons')!!}
{{ Form::close() }}
@endsection
