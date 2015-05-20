@extends('layouts.default')

@section('content')
<div id="noSocio" style="display:none">
	Para ver el status de un socio primero debes de seleccionarlo: <input type="button" id="selectUser" value="Seleccionar socio" />
</div>
<div id="status" style="display:none;width:100%;">
	<div id="userDataContainer" style="padding-bottom:10px;width:auto;background-color:#F1F1F1" class="roundedDashedBox">
		<table id="mainTable" style="padding:10px;border-collapse:collapse;font-family:Arial;font-size:1rem;margin:0 auto;margin-top:10px">
			<tr>
				<td>
						<img style="max-width:300px;max-height:350px" id="imgSocio" onerror="this.src=&quot;img/default/no-image.jpg&quot;" src="img/default/no-image.jpg" />
				</td>
				<td style="max-width:550px;vertical-align:top;padding:10px">
					<div class="roundedDashedForm">
						<table>
							<tr>
								<td class="formTableTD10">ESTADO:</td>
								<td class="formTableTD10Left"><span id="txtStatus" style="font-size:1.5rem;font-weight:bold"></td>
							</tr>
							<tr>
								<td class="formTableTD10" id="proxPagoLabel">Próximo pago:</td>
								<td class="formTableTD10Left"><span id="proximoPago"></td>
							</tr>
						</table>
						<div id='ultimosPagos' class="roundedDashedForm scrollstyle-1" style="max-height:200px;overflow-y:scroll;padding:10px">
						</div>
					</div>	
				</td>
				<td style="padding:10px;max-width:550px;vertical-align:top">

				</td>
			</tr>
			<tr>
				<td>
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
								<td class="formTableTD">Categoría: </td>
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
<script src="{{ asset('/scripts/socios/status.main.js') }}"></script>
<link href="{{ asset('/scripts/common/controls/userSelector.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">

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
		var tipos = eval(<?php print($tiposdepago); ?>);
		var categorias = eval(<?php print($categorias); ?>);
		var promociones = eval(<?php print($promociones); ?>);
		var status = eval(<?php print($status); ?>);
		var socioId = eval(<?php print($idsocio); ?>);
		var socioData = eval(<?php print($socioData); ?>);

		var globalData = {
			tiposDePago: tipos,
			categorias: categorias,
			promociones: promociones,
			status: status,
			socioId: socioId,
			socioData: socioData
		}
		new Status().ini(globalData);
	} );
</script>
@endsection