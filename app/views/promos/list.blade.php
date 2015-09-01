@extends('layouts.default')

@section('content')
<div id="jtablePromos" style="width:100%"></div>
<div style="margin-top:2rem">
	<span>Frecuencias de pago</span>
	<ul>
		<li>1: SEMANAL</li>
		<li>2: MENSUAL</li>
		<li>3: TRIMESTRAL</li>
		<li>4: SEMESTRAL</li>
		<li>5: ANUAL</li>
		<li>6: VISITA</li>
		<li>7: BIMESTRAL</li>
	</ul>
</div>

<link href="{{ asset('/scripts/jtable/themes/lightcolor/blue/jtable.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/scripts/promos/listaPromos.main.js') }}"></script>
<script src="{{ asset('/scripts/jtable/jquery.jtable.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready( function(){
		var promos = new ListaPromos();
		promos.ini();
	} );
</script>

@endsection