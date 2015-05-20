@extends('layouts.default')

@section('content')
<div id="reportes" class="roundedDashedBox">
	<div class="dateRange" style="padding:1em">
		<table>
			<tr style="font-size:.7em">
				<td><input type="button" value="Una semana antes" onclick="window.location.assign('/reportePagos?weeksAgo=<?=$weeksAgo+1?>')"></td>
				@if($weeksAgo > 0)
					<td><input type="button" value="Una semana después" onclick="window.location.assign('/reportePagos?weeksAgo=<?=$weeksAgo-1?>')"></td>
				@endif
			</tr>
		</table>
	</div>
	<table class="reportTable" align="center">
		<thead>
			<tr>
				<th>Tipo de pago</th>
				<th id="dom">Domingo</th>
				<th id="lun">Lunes</th>
				<th id="mar">Martes</th>
				<th id="mie">Miercoles</th>
				<th id="jue">Jueves</th>
				<th id="vie">Viernes</th>
				<th id="sab">Sabado</th>
				<th>Totales</th>
			</tr>
		</thead>
		<tbody>
			@foreach($reporteData as $key => $dataRow)
				<tr>
					<td>{{$key}}</td>
					@foreach(array('sun','mon','tue','wed','thu','fri','sat') as $day)
						@if(array_key_exists($day, $dataRow))
						<td class="{{$day}} tosum">{{$dataRow[$day]}}</td>
						@else
						<td></td>
						@endif
						
					@endforeach
					<td class="income tosum2"></td>
				</tr>
			@endforeach
			<tr >
				<td class="income">Totales</td>
				<td class="income" id="sumSun"></td>
				<td class="income" id="sumMon"></td>
				<td class="income" id="sumTue"></td>
				<td class="income" id="sumWed"></td>
				<td class="income" id="sumThu"></td>
				<td class="income" id="sumFri"></td>
				<td class="income" id="sumSat"></td>
				<td class="total" id="total"></td>
			</tr>
		</tbody>
	</table>
	
</div>
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var weeksAgo = <?=$weeksAgo?>;
		var reportDate = new Date();
		reportDate.setDate(reportDate.getDate()-(weeksAgo*7));

		reportDate.setDate(reportDate.getDate() -1);

		$("#dom").text($("#dom").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate() +1);

		$("#lun").text($("#lun").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate()+1);

		$("#mar").text($("#mar").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate()+1);

		$("#mie").text($("#mie").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate()+1);

		$("#jue").text($("#jue").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate()+1);

		$("#vie").text($("#vie").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		reportDate.setDate(reportDate.getDate()+1);

		$("#sab").text($("#sab").text() + " " + reportDate.getDate() + "/" + (reportDate.getMonth()+1) + "/" + reportDate.getFullYear());

		var totalSun = 0;
		$.each($(".sun"), function(i,e){
			totalSun+= parseInt($(e).text());
		});

		$("#sumSun").text(totalSun);

		var totalMon = 0;
		$.each($(".mon"), function(i,e){
			totalMon+= parseInt($(e).text());
		});

		$("#sumMon").text("$" + totalMon);

		var totalTue = 0;
		$.each($(".tue"), function(i,e){
			totalTue+= parseInt($(e).text());
		});

		$("#sumTue").text("$" + totalTue);

		var totalWed = 0;
		$.each($(".wed"), function(i,e){
			totalWed+= parseInt($(e).text());
		});

		$("#sumWed").text("$" + totalWed);

		var totalThu = 0;
		$.each($(".thu"), function(i,e){
			totalThu+= parseInt($(e).text());
		});

		$("#sumThu").text("$" + totalThu);

		var totalFri = 0;
		$.each($(".fri"), function(i,e){
			totalFri+= parseInt($(e).text());
		});

		$("#sumFri").text("$" + totalFri);

		var totalSat = 0;
		$.each($(".sat"), function(i,e){
			totalSat+= parseInt($(e).text());
		});

		$("#sumSat").text("$" + totalSat);

		var totalTotales = 0;

		$.each($(".tosum"), function(i,e){
			totalTotales += parseInt($(e).text());
		});

		$("#total").text("$" + totalTotales);

		$.each($(".tosum2"), function(i,e){
			var toSum = $(e).parent().find(".tosum");

			var tot = 0;
			$.each(toSum, function(ind, elm){
				tot += parseInt($(elm).text());
			});

			$(e).text("$"+tot);
		});
	});
</script>
@endsection