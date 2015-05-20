@extends('layouts.default')

@section('content')
<div id="pagoServicios">
	<div id="pagoServicioForm" class="roundedDashedBox">
		<table id="tablaPagoServicios" class="formTable" style="margin: 0 auto; margin-top:1rem;margin-bottom:1rem">
			<tr>
				<td class="formTableTD">Servicio:</td>
				<td><select class="rounded" id="selectServicios"><option value="-1"></option></select></td>
			</tr>
			<tr>
				<td class="formTableTD">Monto $:</td>
				<td><input class="field rounded" id="txtMonto" type="text" maxlength="5" style="width:250px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Comentario:</td>
				<td><input class="field rounded" id="txtComentario" type="text" maxlength="100" style="width:250px"/></td>
			</tr>
			<tr style="padding:20px">
				<td class="formTableTD"></td>
				<td style="text-align:right"><input class="rounded" id="saveButton" type="button" value="Pagar servicio" /></td>
			</tr>
		</table>
	</div>
</div>

<style type="text/css">

#tablaPagoServicios td {
	padding: 10px;
}
</style>

<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/servicios/pagoServicios.main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/servicios/servicios.main.js') }}"></script>
<script type="text/javascript">
	$(document).ready( function(){
		var servicios = {{$servicios}};

		Servicios.fillSelect("#selectServicios",servicios);

		new PagoServicio().ini();
	} );
</script>

@endsection