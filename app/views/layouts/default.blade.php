<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Delta Gym</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/layouts/default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/menu/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/scripts/jqueryUI/css/smoothness/jquery-ui-1.10.3.custom.min.css') }}">
  </head>
  <body>
  	<div id="main">
  		<div id="topBar">
  			<div id="topBarUp"><span style="font-align:left;color:#EBECF0;padding:10px;font-family:Impact;font-size:1.9rem">DELTA GYM ADMINISTRATION</span> </div>
  			<div id="topBarDown">
  				<div id="menuContainer" style="text-align:center">
	  				<ul id="menu" style="display:inline-block">
						<li><a href="/">Inicio</a></li>
						<li class="menuTopOption">
							<a href="#">Socios</a>
								<ul>
									<li class="listarsocios"><a href="busquedaSocios">Listar Socios</a></li>
									<li class="inscripcionsocio"><a href="inscripcion">Inscripción</a></li>
									<li class="realizarpagosocio"><a href="pago">Realizar pago</a></li>
									<li class="verstatussocio"><a href="status">Ver estado</a></li>
								</ul>
						</li>
						<li class="menuTopOption">
							<a href="#">Empleados</a>
								<ul>
									<li class="altaempleado"><a href="agregarEmpleadoView">Dar de alta</a></li>
									<li class="listarempleados"><a href="listarEmpleadosView">Listar empleados</a></li>
									<li class="pagarempleado"><a href="pagarEmpleadoView">Pagar a empleado</a></li>
								</ul>
						</li>
						<li class="menuTopOption"><a href="#">Administración</a>
								<ul>
									<li class="pagarservicio"><a href="pagarServicioView">Pagar servicios</a></li>
									<li class="listarlogoperaciones"><a href="listarLogEventos">Log de operaciones</a></li>
									<li class="listarpagossocios"><a href="listarPagos">Listar pagos de socios</a></li>
									<li class="listarpagosaempleados"><a href="listarPagosEmpleados">Listar pagos a empleados</a></li>
									<li class="listarpagosservicios"><a href="listarPagosServicios">Listar pagos de servicios</a></li>
									<li class="reportes"><a href="reportes">Reportes</a></li>
								</ul>
						</li>
						<li class="menuTopOption"><a href="#">Configuración</a>
								<ul>

								</ul>
						</li>
						<li><a href="logout">Salir</a></li>
					</ul>
  				</div>
  			</div>
  		</div>
		<div id="mainContent">
			<div id="sectionTitle">
				<span id="sectionText"><?php if(isset($sectionText)){echo $sectionText;} ?></span>
			</div>
			<div id="sectionContent">
			    @yield('content')
			</div>
		</div>
		<div id="bottomBar">
		</div>
		<div id="dialog" style="display:none;">
			<span id="dialogMsg"></span>
		</div>
  	</div>
    <script src="{{ asset('/scripts/prefixfree/prefixfree.min.js') }}"></script>
    <script src="{{ asset('/scripts/common/deltagym.common.js') }}"></script>
    <script src="{{ asset('/scripts/defaultLayout/gym.main.js') }}"></script>
    <script type="text/javascript">
    </script>
  </body>
</html>