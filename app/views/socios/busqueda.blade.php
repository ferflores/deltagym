@extends('layouts.default')

@section('content')
<div style="width:100%;text-align:right;height:2em;font-size:0.9em">
	<table align="right">
		<tr>
			<td>Buscar por nombre: </td>
			<td><input id="txtNombre" type="text" maxlength="30" /></td>
			<td><input id="btnBuscar" type="button" value="Buscar" /></td>
		</tr>
	</table>
</div>
<div id="jtableSocios" style="width:100%"></div>

<input type="hidden" id="hiddenCategorias" value={{$categorias}} />
<div id="showPic">

</div>

<link href="{{ asset('/scripts/jtable/themes/lightcolor/blue/jtable.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/socios/busquedaSocios.main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/categorias/categorias.main.js') }}"></script>
<script src="{{ asset('/scripts/jtable/jquery.jtable.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('/scripts/common/uploadFile.js') }}"></script>
<script src="{{ asset('/scripts/common/controls/socioPicture.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready( function(){
		new BusquedaSocios().ini({{$status}});
	} );
</script>

@endsection