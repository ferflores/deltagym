@extends('layouts.default')

@section('content')
<div id="registroempleados">
	<div id="registroEmpleadosForm" class="roundedDashedBox">
		<table id="tablaEmpleados" class="formTable" style="margin: 0 auto; margin-top:1rem;margin-bottom:1rem">
			<tr>
				<td class="formTableTD">Nombre:</td>
				<td><input class="field firstFocus rounded" id="txtNombre" type="text" maxlength="50" style="width:250px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Apellido Paterno:</td>
				<td><input class="field rounded" id="txtApellidoP" type="text" maxlength="50" style="width:350px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Apellido Materno:</td>
				<td><input class="field rounded" id="txtApellidoM" type="text" maxlength="50" style="width:350px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Email:</td>
				<td><input class="field rounded" id="txtEmail" type="text" maxlength="100" style="width:450px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Comentario:</td>
				<td><input class="field rounded" id="txtComentario" type="text" maxlength="100" style="width:450px"/></td>
			</tr>
			<tr>
				<td class="formTableTD">Foto</td>
				<td style="text-align:left">
					<input type="file" id="imgFile" name="files" accept="image/*" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td><div id="progressBar" style="height:15px"></div></td>
			</tr>
			<tr style="height:20px"></tr>
			<tr style="height:20px">
				<td></td>
				<td style="text-align:right">
					<div id="picBox"></div>
				</td>
			</tr>
			<tr style="padding:20px">
				<td class="formTableTD"></td>
				<td style="text-align:right"><input class="rounded" id="saveButton" type="button" value="Dar de alta" /></td>
			</tr>
		</table>
	</div>
</div>

<style type="text/css">

#tablaEmpleados td {
	padding: 10px;
}
</style>

<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/empleados/altaempleado.main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/common/uploadFile.js') }}"></script>
<script type="text/javascript">
	$(document).ready( function(){
		new AltaEmpleados().ini();
	} );
</script>

@endsection