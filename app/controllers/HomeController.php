<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{

		return View::make('index',array(
			 'sectionText' => '- Inicio Delta Gym',
			// 'totalPagosDelDia' => $this->dashBoardStatus(),
			// 'totalSociosDelDia' => $this->sociosDelDia() ,
			// 'clientesProximosAPagar' => $this->clientesProximosAPagar() ,
			// 'clientesActivos' => $this->clientesActivos() ,
			// 'clientesSinPagar' => $this->clientesSinPagar() ,
			// 'clientesSinPagos' => $this->clientesSinPagos() ,
			// 'clientesInactivos' => $this->clientesInactivos() 
			));
	}

	public function noAccess()
	{
		return View::make('noAccess',array('sectionText' => '- Sin acceso' ));
	}

	private function getOffset(){

		return Config::get('configKeys.offsetHoursString');
	}

	public function getClassesToRemove(){
		if(Auth::check()){
			$iduser = Auth::user()->id;
			$clases = DB::table('permisos')->lists('clase');
			$userRoles = DB::table('userroles')->where("iduser","=",$iduser)->lists('idrole');
			$userClasses = array();

			foreach ($userRoles as $userRole) {
				$permisos = DB::table('rolespermisos')->where("idrole","=",$userRole)->lists('idpermiso');

				foreach ($permisos as $permiso) {
					$clase = Permisos::find($permiso)->clase;
					array_push($userClasses, $clase);
				}

			}
			
			$diferencia = array_diff($clases, $userClasses);

			return json_encode($diferencia);
		}
			return json_encode(-1);
	}

	private function dashBoardStatus(){

		$countPagosDelDiaQuery = "SELECT count(*) total, tdp.nombre 
					FROM pagos P INNER JOIN tiposdepago tdp
						ON P.idtipodepago = tdp.id
					WHERE P.activo AND DATE(CONVERT_TZ(P.fecha,'+00:00','".$this->getOffset()."')) = DATE(CONVERT_TZ(NOW(),'+00:00','".$this->getOffset()."'))
					GROUP BY P.idtipodepago";

		$countPagosDelDia = DB::select($countPagosDelDiaQuery);
		return $countPagosDelDia;
	}

	private function sociosDelDia(){
		
		$countSociosDelDiaQuery = "SELECT count(*) total
					FROM socios S
					WHERE S.activo AND DATE(CONVERT_TZ(S.created,'+00:00','".$this->getOffset()
						."')) = DATE(CONVERT_TZ(NOW(),'+00:00','".$this->getOffset()
					."'))";
		
		$countSociosDelDia = DB::select($countSociosDelDiaQuery);
		return $countSociosDelDia;
	}

	private function clientesProximosAPagar(){
		$query = "SELECT count(*) total FROM socios s 
									where CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()."') <=(select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1) 
									AND CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()."') >= DATE_SUB((select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1),interval 3 day)";

		$result = DB::select($query);
		return $result;
	}

	private function clientesSinPagar(){
		$query = "SELECT count(*) total FROM socios s 
									where CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()."') > (select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1)
									AND DATE_SUB(CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()."'),interval 2 month) < (select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1)";

		$result = DB::select($query);
		return $result;
	}

	private function clientesSinPagos(){
		$query = "SELECT count(*) total FROM socios s WHERE (SELECT COUNT(*) from pagos where idsocio=s.id and pagos.activo) < 1";

		$result = DB::select($query);
		return $result;
	}

	private function clientesActivos(){
		$query = "SELECT count(*) total FROM socios s 
									where CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()
										."') <= (select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1)
									AND CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()
										."') < DATE_SUB((select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1),interval 3 day)";

		$result = DB::select($query);
		return $result;
	}

	private function clientesInactivos(){
		$query = "SELECT count(*) total FROM socios s 
									where DATE_SUB(CONVERT_TZ(CURRENT_DATE(),'+00:00','".$this->getOffset()
										."'),interval 2 month) > (select proximopago from pagos where idsocio= s.id and pagos.activo order by id desc limit 1)";

		$result = DB::select($query);
		return $result;
	}

}