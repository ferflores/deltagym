@extends('layouts.default')

@section('content')
<div id="noEmpleado" style="display:none">
	Para realizar un pago primero debe de seleccionar un empleado: <input type="button" id="selecEmpleado" value="Seleccionar empleado" />
</div>
<div id="pagos" style="display:none;width:100%;">
	<div id="userDataContainer" style="padding-bottom:10px;width:auto;background-color:#F1F1F1" class="roundedDashedBox">
		<table id="mainTable" style="border-collapse:collapse;font-family:Arial;font-size:1rem;margin:0 auto;margin-top:10px">
			<tr>
				<td>
						<img style="max-width:300px;max-height:350px" id="imgEmpleado" onerror="this.src=&quot;img/default/no-image.jpg&quot;" src="img/default/no-image.jpg" />
				</td>
				<td style="padding:10px;max-width:400px;vertical-align:top">
					<div class="roundedDashedForm">
						<table>
							<tr>
								<td class="formTableTD">Total $:</td>
								<td class="pagoEmpleadoInput"><input class="rounded" maxlength="4" type="text" id="txtTotal"></input></td>
							</tr>
							<tr>
								<td class="formTableTD">Comentario:</td>
								<td class="pagoEmpleadoInput"><input class="rounded" maxlength="99" type="text" id="txtComentario"></input></td>
							</tr>
							<tr>
								<td class="formTableTD"></td>
								<td class="pagoEmpleadoInput"><input  type="button" id="btnPagar" value="Pagar"></input></td>
							</tr>
						</table>
					</div>	
				</td>
			</tr>
			<tr>
				<td style="padding:10px">
					<div id="empleadoData" style="width:100%">
						<table>
							<tr>
								<td class="formTableTD">ID:</td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="idEmpleado"></td>
							</tr>
							<tr>
								<td class="formTableTD">Nombre:</td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="nombreSocio"></td>
							</tr>
							<tr>
								<td class="formTableTD">Apellido P:</td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="apellidoPSocio"></td>
							</tr>
							<tr>
								<td class="formTableTD">Apellido M:</td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="apellidoMSocio"></td>
							</tr>
							<tr>
								<td class="formTableTD">Email: </td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="emailSocio"></td>
							</tr>
							<tr>
								<td class="formTableTD">Comentario: </td>
								<td style="border-bottom:1px dashed #000000; color:#BF3939;max-width:250px" class="comentarioSocio"></td>
							</tr>
						</table>
					</div>
				</td>
				<td style="text-align:right;vertical-align:bottom;text-align:right">
					<input id="selecOtro" type="button" value="Seleccionar otro empleado" />
				</td>
			</tr>
		</table>
	</div>

</div>


<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src="{{ asset('/scripts/common/controls/empleadoSelector.js') }}"></script>
<script src="{{ asset('/scripts/empleados/pagoEmpleados.main.js') }}"></script>
<link href="{{ asset('/scripts/common/controls/empleadoSelector.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">

#mainTable td {
	padding: 10px;
}

#empleadoData td {
	padding: 4px;
}

#imgEmpleado {
	max-height:450px;
	max-width:300px;
	width:300px;
	webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px;
	border: 3px solid #666;
}

.pagoEmpleadoInput{
	padding-right: 10px;
}


</style>

<script type="text/javascript">
	$(document).ready( function(){
		var pago = new PagoEmpleado();
		pago.ini();

	} );
</script>
@endsection