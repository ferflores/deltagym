<?php

class BusquedasController extends BaseController {
	
	public function index()
	{
		$categorias = Categoria::all();
		$status = Status::all();
		return View::make('socios.busqueda',array('sectionText' => '- Busqueda Socios','categorias'=>$categorias,'status'=>$status));
	}

	public function listarSocios(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');
		$nombre = Input::get('nombre');
		$offset = Config::get('configKeys.offsetHoursString');

		$sortBy = 's.id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "
			select s.id id, s.nombre nombre, s.apellidop apellidop, s.apellidom apellidom, s.email email, s.created created, s.imgname imgname, s.comentario comentario, s.idcategoria idcategoria, c.nombre categoria

				from socios s inner join categorias c on s.idcategoria = c.id
				WHERE s.nombre like '%".$nombre."%'
				order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = Socio::where('nombre','LIKE','%'.$nombre.'%')->count();
		$records->Result = "OK";
		return json_encode($records);
	}

	public function listarSociosPorNombre(){
		$records = new stdClass();

		$query = "
			select *
				from socios s
				WHERE s.nombre like '%".Input::get('nombre')."%'
					and s.apellidop like '%".Input::get('apellido')."%'
				order by s.created limit 35";

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->Result = "OK";

		return json_encode($records);
	}

	public function listarEmpleadosPorNombre(){
		$records = new stdClass();
		$records->Records = Empleado::where('nombre','LIKE','%'.Input::get('nombre').'%')->take(30)->orderBy('id','desc')->get()->toArray();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function listarPagos(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');
		$offset = Config::get('configKeys.offsetHoursString');
		$sortBy = 'p.id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "
			select p.id id, p.idsocio socio, t.nombre tipodepago, p.monto monto, p.fecha fecha, CONVERT_TZ(p.fecha,'+00:00','".$offset."') fechaWithOffset, p.proximopago proximopago, p.idtipodepago idtipodepago,
			IFNULL((select nombre from promociones where id = (select idpromocion from promocionesaplicadas where idpago = p.id)),'-') as promocion,
			IFNULL((select id from promociones where id = (select idpromocion from promocionesaplicadas where idpago = p.id)),'-1') as idpromocion
			from pagos p 
			inner join tiposdepago t on p.idtipodepago = t.id
			WHERE p.activo
			order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('pagos')->count();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function listarPagosServicios(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');

		$sortBy = 'ps.id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "
			select ps.id id, s.nombre servicio, e.monto monto, e.fecha fecha, ps.comentario comentario 
				from pagosservicios ps inner join servicios s on ps.idservicio = s.id
				inner join egresos e on ps.idegreso = e.id
			WHERE ps.activo
			order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('pagosservicios')->count();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function listarPagosEmpleados(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');

		$sortBy = 'pe.id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "
			select pe.id id, e.nombre nombre, e.apellidop apellidop, eg.monto monto, eg.fecha fecha, pe.comentario comentario 
				from pagosempleados pe inner join empleados e on pe.idempleado = e.id
				inner join egresos eg on pe.idegreso = eg.id
			where pe.activo
			order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('pagosempleados')->count();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function listarLogEventos(){

		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');

		$sortBy = 'l.id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "
			select u.username username, e.nombre operacion, l.mensaje mensaje, l.fecha fecha 
			from gymlog l 
			inner join eventos e on l.idevento = e.id
			inner join users u on l.idusuario = u.id
			order by ".$sortBy." ".$sortOrder." ".$limit;


		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('gymlog')->count();
		$records->Result = "OK";

		return json_encode($records);
	}

	public function indexListaPagos(){

		return View::make('pagos.listarPagos',array('sectionText' => '- Lista de pagos',
			'promociones'=> Promocion::All(),
			'tiposDePago'=> TipoDePago::All()
			));
	}

	public function indexListaPagosServicios(){

		return View::make('pagos.listarPagosServicios',array('sectionText' => '- Lista de pagos de servicios'));
	}

	public function indexListaPagosEmpleados(){

		return View::make('pagos.listarPagosEmpleados',array('sectionText' => '- Lista de pagos a empleados'));
	}

	public function indexLogEventos(){
		return View::make('log.logEventos',array('sectionText' => '- Log de operaciones'));
	}

	public function listarEmpleadosView()
	{
			return View::make('empleados.lista',array('sectionText' => '- Lista de empleados'));
	}

	public function listarEmpleados(){
		$jtStartIndex = Input::get('jtStartIndex');
		$jtPageSize = Input::get('jtPageSize');
		$jtSorting = Input::get('jtSorting');

		$sortBy = 'id';
		$sortOrder = 'DESC';

		if(sizeof($jtSorting)>0){
			$sort = explode(" ",$jtSorting);
			$sortBy = $sort[0];
			$sortOrder = $sort[1];
		}

		$limit = "";
		if($jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtStartIndex.",".$jtPageSize;
		}else if(!$jtStartIndex && $jtPageSize){
			$limit = "limit ".$jtPageSize;
		}

		$query = "select * from empleados order by ".$sortBy." ".$sortOrder." ".$limit;

		$records = new stdClass();
		$records->Records = DB::select($query);
		$records->TotalRecordCount = DB::table('empleados')->count();
		$records->Result = "OK";
		return json_encode($records);
	}
}

?>