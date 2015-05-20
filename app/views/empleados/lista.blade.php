@extends('layouts.default')

@section('content')
<div id="jtableEmpleados" style="width:100%"></div>

<link href="{{ asset('/scripts/jtable/themes/lightcolor/blue/jtable.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/scripts/jquery/jquery1.10.2.js') }}"></script>
<script src="{{ asset('/scripts/jqueryUI/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src="{{ asset('/scripts/jtable/jquery.jtable.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('/scripts/empleados/listaEmpleados.main.js') }}"></script>
<script type="text/javascript">
	$(document).ready( function(){
		new ListaEmpleados().ini();
	} );
</script>

@endsection