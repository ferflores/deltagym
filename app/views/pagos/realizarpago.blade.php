@extends('layouts.default')

@section('content')
<div id="noSocio" style="display:none">
	Para realizar un pago primero debe de seleccionar un socio: <input type="button" id="selectUser" value="Seleccionar socio" />
</div>
<div id="pagos" style="display:none;width:100%;">
	<div id="userDataContainer" style="padding-bottom:10px;width:auto;background-color:#F1F1F1" class="roundedDashedBox">
		<table id="mainTable" style="border-collapse:collapse;font-family:Arial;font-size:1rem;margin:0 auto;margin-top:10px">
			<tr>
				<td>
						<img style="max-width:300px;max-height:350px" id="imgSocio" onerror="this.src=&quot;img/default/no-image.jpg&quot;" src="img/default/no-image.jpg" />
				</td>
				<td style="padding:10px;max-width:300px;vertical-align:top">
					<div class="roundedDashedForm">
						<table>
							<tr>
								<td class="formTableTD">Tipo de pago:</td>
								<td><select class="rounded" id="selectTipoDePago"><option value="-1"></option></select></td>
							</tr>
							<tr>
								<td class="formTableTD">Aplicar Promo:</td>
								<td><select class="rounded" id="selectPromo"><option value="-1"></option></select></td>
							</tr>
							<tr>
								<td class="formTableTD">Total $:</td>
								<td><input readonly="readonly" maxlength="4" type="text" id="txtTotal"></input></td>
							</tr>
							<tr>
								<td class="formTableTD"></td>
								<td><input type="button" id="btnPagar" value="Pagar"></input></td>
							</tr>
						</table>
					</div>	
				</td>
			</tr>
			<tr>
				<td style="padding:10px">
					<div id="socioData" style="width:100%">
						<table>
							<tr>
								<td class="formTableTD">ID:</td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="idSocio"></td>
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
								<td class="formTableTD">Categoria: </td>
								<td style="border-bottom:1px dashed #000000; color:#0A1E26" class="categoriaSocio"></td>
							</tr>
							<tr>
								<td class="formTableTD">Comentario: </td>
								<td style="border-bottom:1px dashed #000000; color:#BF3939;max-width:250px" class="comentarioSocio"></td>
							</tr>
						</table>
					</div>
				</td>
				<td style="text-align:right;vertical-align:bottom;text-align:right">
					<input id="selecOtro" type="button" value="Seleccionar otro socio" />
				</td>
			</tr>
		</table>
	</div>

</div>


<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src="{{ asset('/scripts/common/controls/userSelector.js') }}"></script>
<script src="{{ asset('/scripts/pagos/pagos.main.js') }}"></script>
<link href="{{ asset('/scripts/common/controls/userSelector.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">

#mainTable td {
	padding: 10px;
}

#socioData td {
	padding: 4px;
}

#imgSocio {
	max-height:450px;
	max-width:300px;
	width:300px;
	webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px;
	border: 3px solid #666;
}


</style>

<script type="text/javascript">
	$(document).ready( function(){
		var costos = eval(<?php print($costosdepago); ?>);
		var tipos = eval(<?php print($tiposdepago); ?>);
		var categorias = eval(<?php print($categorias); ?>);
		var promociones = eval(<?php print($promociones); ?>);

		var globalData = {
			costosDePago: costos,
			tiposDePago: tipos,
			categorias: categorias,
			promociones: promociones
		}

		var pago = new Pago();
		pago.ini(globalData);

	} );
</script>
@endsection