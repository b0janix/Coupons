@extends('Layouts.master')

@section('content')
<h3>Following coupons will be deleted:</h3>

@foreach($checkBoxOne as $checked)
{{$checked[0]}} {{$checked[1]}} {{$checked[2]}}<br>
@endforeach
<br><br>
{!!Form::open(array('method'=>'DELETE','route' => ['distribute.destroy', $string]))!!}
{!!Form::submit('Delete a coupon')!!}
{!!Form::close()!!}
<br>
<a href="{{ URL::previous() }}">Back</a>
@endsection