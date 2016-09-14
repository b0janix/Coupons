@extends('Layouts.master')

@section('content')
<?php/*This coupon variable contains an array of coupon objects that have an access to a title pivot field which 
value is equal to the value of the title URI parameter passed when the title link is clicked*/
/*It basicly determines the number of coupon and worker objects, on which base we are setting 
the numeric limit of the for cycle bellow*/?>
@for($i=0;$i < count($coupons);$i++)
{{Form::checkbox('rb',null,null,['id'=>'results'.$i,'class'=>'results'])}}<br>
<div class=<?php echo "results"?> id=<?php echo "results".$i?>>{{$coupons[$i]->coupon_number}} {{$workers[$i]->accountNumber}} {{$workers[$i]->workerName}} </div><br>
@endfor

<br>
{!!Form::open(array('route' => 'dlist.verify'))!!}
{!!Form::hidden('secret','',['class'=>'secret_one'])!!}
{!!Form::hidden('meal',$meal)!!}
{!!Form::hidden('month',$month)!!}
{!!Form::submit('View selections',['id'=>'detach'])!!}
{!!Form::close()!!}
<br>
{{ Form::open(['route' => 'distribute.index', 'method' => 'GET'])}}
{!!Form::submit('Back')!!}
{{ Form::close() }}
@endsection
