@extends('layouts.default')

@section('content')
<div id="reportes" class="roundedDashedBox">
	<div class="dateRange" style="padding:1em">
		<table>
			<tr style="font-size:.7em">
				<td>Desde la fecha: </td><td><input id="minDate" type="text" /></td><td>Hasta: </td><td><input id="maxDate" type="text" /></td>
				<td><input id="getReport" type="button" value="Obtener reporte" /></td>
			</tr>
		</table>
	</div>
	<h1 class="reportSection">Totales:</h1>
	<table class="reportTable" align="center">
		<tbody>
			<tr>
				<td>Total de ingresos: </td><td class="income">${{$totalIngresos}}</td>
			</tr>
			<tr>
				<td>Total de egresos: </td><td class="outcome">${{$totalEgresos}}</td>
			</tr>
			<tr>
				<td>Ingresos - Egresos: </td><td class="total">${{$totalIngresos - $totalEgresos}}</td>
			</tr>
		</tbody>
	</table>
	<h1 class="reportSection">Ingresos por categoría de socio:</h1>
	<table class="reportTable" align="center">
		<thead>
			<tr>
				<th>Categoría</td>
				<th>Tipo de pago</td>
				<th>Cuota</td>
				<th>Cantidad de pagos</td>
				<th>Monto</td>
			<tr>
		</thead>
		<tbody>
			@if($ingresosPorCategoria != null)
				<?php 
					$totalIngresosPorCategoria = 0;
				 ?>
				@foreach($ingresosPorCategoria as $ingresoPorCategoria)
				<?php
					$totalIngresosPorCategoria = $totalIngresosPorCategoria + intval($ingresoPorCategoria->monto);
				?>
					<tr>
						<td>
							{{ $ingresoPorCategoria->nombreCategoria }}
						</td>
						<td>
							{{ $ingresoPorCategoria->tipoDePago }}
						</td>
						<td>
							${{ $ingresoPorCategoria->cuota }}
						</td>
						<td>
							{{ $ingresoPorCategoria->cantidad }}
						</td>
						<td>
							${{ $ingresoPorCategoria->monto }}
						</td>
					</tr>
				@endforeach
					<tr>
						<td>
						</td>
						<td>
						</td>
						<td>
						</td>
						<td style="text-align:right">
							Total:
						</td>
						<td class="income">
							${{ $totalIngresosPorCategoria }}
						</td>
					</tr>
			@endif
		</tbody>
	</table>
	<h1 class="reportSection">Promociones Aplicadas:</h1>
	<table class="reportTable" align="center">
		<thead>
			<tr>
				<th>Promoción</td>
				<th>Cantidad de veces aplicada</td>
				<th>Cuota de promoción</td>
				<th>Total Ingreso</td>
			<tr>
		</thead>
		<tbody>
			@if($promocionesAplicadas != null)
				<?php 
					$totalPromocionesAplicadas = 0;
				 ?>
				@foreach($promocionesAplicadas as $promocionAplicada)
					<?php
						$totalPromocionesAplicadas = $totalPromocionesAplicadas + intval($promocionAplicada->monto);
					?>
					<tr>
						<td>
							{{ $promocionAplicada->nombre }}
						</td>
						<td>
							{{ $promocionAplicada->cantidad }}
						</td>
						<td>
							${{ $promocionAplicada->costo }}
						</td>
						<td>
							${{ intval($promocionAplicada->monto)}}
						</td>
					</tr>
				@endforeach
					<tr>
						<td>
						</td>
						<td>
						</td>
						<td style="text-align:right">
							Total:
						</td>
						<td class="income">
							${{$totalPromocionesAplicadas}}
						</td>
					</tr>
			@endif
		</tbody>
	</table>
	<h1 class="reportSection">Pagos a empleados:</h1>
	<table class="reportTable" align="center">
		<thead>
			<tr>
				<th>Nombre de empleado</td>
				<th>Monto:</td>
			<tr>
		</thead>
		<tbody>
			@if($pagosEmpleados != null)
				<?php 
					$totalPagosEmpleados = 0;
				 ?>
				@foreach($pagosEmpleados as $pagoEmpleado)
					<?php 
						$totalPagosEmpleados = $totalPagosEmpleados + intval($pagoEmpleado->monto);
				 	?>
					<tr>
						<td>
							{{ $pagoEmpleado->nombre." ".$pagoEmpleado->apellidop." ".$pagoEmpleado->apellidom }}
						</td>
						<td>
							${{ intval($pagoEmpleado->monto) }}
						</td>
					</tr>
				@endforeach
					<tr>
						<td style="text-align:right">
							Total:
						</td>
						<td class="outcome">
							${{ $totalPagosEmpleados }}
						</td>
					</tr>
			@endif
		</tbody>
	</table>
	<h1 class="reportSection">Pagos de servicios:</h1>
	<table class="reportTable" align="center">
		<thead>
			<tr>
				<th>Nombre de servicio</td>
				<th>Monto:</td>
			<tr>
		</thead>
		<tbody>
			@if($pagosServicios != null)
				<?php 
					$totalPagosServicios = 0;
				 ?>
				@foreach($pagosServicios as $pagoServicio)
					<?php 
						$totalPagosServicios = $totalPagosServicios + intval($pagoServicio->monto);
				 	?>
					<tr>
						<td>
							{{ $pagoServicio->nombre }}
						</td>
						<td>
							${{ intval($pagoServicio->monto) }}
						</td>
					</tr>
				@endforeach
					<tr>
						<td style="text-align:right">
							Total:
						</td>
						<td class="outcome">
							${{ $totalPagosServicios }}
						</td>
					</tr>
			@endif
		</tbody>
	</table>
</div>
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/reportes/reporteGeneral.js') }}"></script>
<script src="{{ asset('/scripts/jtable/jquery.jtable.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		new ReporteGeneral().ini();
		var minDate = '{{$minDate}}';
		var maxDate = '{{$maxDate}}';
		if(minDate.length>0){
			minDate = minDate.split(" ")[0];
		}
		var maxDate = '{{$maxDate}}';
		if(maxDate.length>0){
			maxDate = maxDate.split(" ")[0];
		}
		$('#minDate').val(minDate);
		$('#maxDate').val(maxDate);
	});
</script>
@endsection