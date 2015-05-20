@extends('layouts.default')

@section('content')
<div id="reportes" class="roundedDashedBox">
	<ul>
	@foreach($Reportes as $reporte)
		<li>
			<a href="/{{$reporte->url}}"> {{$reporte->nombre}} </a>
		</li>
	@endforeach
	</ul>
</div>
@endsection