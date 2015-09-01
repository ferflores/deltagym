<?php

class ReportesController extends BaseController {
	
	public function index()
	{
		return View::make('reportes.index',array(
			'sectionText' => '- Reportes',
			'Reportes' => Reporte::All()));
	}

	public function reportePagos(){
		$weeksAgo = Input::get('weeksAgo');

		$query = "SELECT dayofweek(date(p.fecha)) dayweek,
					CONCAT(IF(pro.nombre is null, tdp.nombre, pro.nombre ), ' - ', c.nombre) nombrepago, sum(p.monto) monto, count(*) conteo
					FROM pagos p
						INNER JOIN tiposdepago tdp on p.idtipodepago = tdp.id
						LEFT JOIN promocionesaplicadas pa on pa.idpago = p.id
						LEFT JOIN promociones pro on pro.id = pa.idpromocion
						INNER JOIN socios s on p.idsocio = s.id
						INNER JOIN categorias c on s.idcategoria = c.id
					WHERE YEARWEEK(p.fecha) = YEARWEEK(CURDATE() - interval ".(7*$weeksAgo)." day)
					GROUP BY nombrepago, dayweek
					ORDER BY nombrepago";

		$weekDays = array(
			'sun' => array(), //lun
			'mon' => array(), //mar ...
			'tue' => array(),
			'wed' => array(),
			'thu' => array(),
			'fri' => array(),
			'sat' => array()
			);
		$reporteData = DB::select($query);

		$newData = array();

		for ($i=0; $i < sizeof($reporteData); $i++) {

			if(!array_key_exists($reporteData[$i]->nombrepago, $newData)){
				$newData[$reporteData[$i]->nombrepago] = array();
			}

			if($reporteData[$i]->dayweek == 1){
				$newData[$reporteData[$i]->nombrepago]['sun'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 2) {
				$newData[$reporteData[$i]->nombrepago]['mon'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 3) {
				$newData[$reporteData[$i]->nombrepago]['tue'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 4) {
				$newData[$reporteData[$i]->nombrepago]['wed'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 5) {
				$newData[$reporteData[$i]->nombrepago]['thu'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 6) {
				$newData[$reporteData[$i]->nombrepago]['fri'] = $reporteData[$i]->monto;
			}elseif ($reporteData[$i]->dayweek == 7) {
				$newData[$reporteData[$i]->nombrepago]['sat'] = $reporteData[$i]->monto;
			}
		}

		return View::make('reportes.reportePagos',array(
			'sectionText' => '- Reporte de pagos semanal',
			'reporteData' => $newData,
			'weeksAgo' => $weeksAgo));
	}


	public function reporteGeneral()
	{
		$minDate = Input::get('minDate');
		$maxDate = Input::get('maxDate');
		$offset = Config::get('configKeys.offsetHoursString');

		if(!$minDate){
			$minDate = date('Y-m-01');
		}

		if(!$maxDate){
			$maxDate = date('Y-m-d');
		}

		$totalIngresosQuery = "SELECT SUM(monto) total
									FROM pagos
								WHERE activo
								AND CONVERT_TZ(fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59' ";

		$totalEgresosQuery = "SELECT SUM(monto) total
									FROM egresos
								WHERE activo
								AND CONVERT_TZ(fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59' ";

		$ingresosPorCategoriaQuery = "SELECT  C.nombre nombreCategoria, TDP.nombre tipoDePago, CDP.costo cuota, SUM(P.monto) monto, COUNT(P.monto) cantidad
										FROM pagos P
											INNER JOIN tiposdepago TDP ON P.idtipodepago = TDP.id
											INNER JOIN socios S ON P.idsocio = S.id
											INNER JOIN categorias C ON S.IDCATEGORIA = C.ID
											INNER JOIN costosdepago CDP ON C.ID = CDP.idcategoria AND TDP.id = CDP.idtipodepago
										WHERE P.activo
										AND CONVERT_TZ(P.fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59'
										GROUP BY C.nombre, TDP.nombre";

		$promocionesAplicadasQuery = "SELECT Pro.nombre nombre, Count(Pro.id) cantidad, SUM(P.monto) monto, Pro.costo costo
										FROM pagos P
										INNER JOIN promocionesaplicadas PA ON P.id = PA.idpago
										INNER JOIN promociones Pro ON PA.idpromocion = Pro.id
									WHERE P.activo
									AND CONVERT_TZ(P.fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59'
									GROUP BY Pro.nombre, Pro.costo";

		$pagosEmpleadosQuery = "SELECT EM.nombre nombre, EM.apellidop apellidop, EM.apellidom apellidom, SUM(E.monto) monto
									FROM egresos E
										INNER JOIN pagosempleados PE ON E.id = PE.idegreso
										INNER JOIN empleados EM ON PE.idempleado = EM.id
								WHERE E.activo
								AND E.idtipodeegreso = 1
								AND CONVERT_TZ(E.fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59'
								GROUP BY  EM.nombre, EM.apellidop, EM.apellidom";

		$pagosServiciosQuery = "SELECT S.nombre nombre, SUM(E.monto) monto
									FROM egresos E
								    INNER JOIN pagosservicios PS ON E.id = PS.idegreso
								    INNER JOIN servicios S ON PS.idservicio = S.id
								WHERE E.activo
								AND E.idtipodeegreso = 2
								AND CONVERT_TZ(E.fecha,'+00:00','".$offset."') BETWEEN '$minDate' AND '$maxDate 23:59:59'
								GROUP BY S.nombre";
		
		$totalIngresos = DB::select($totalIngresosQuery);
		$totalEgresos = DB::select($totalEgresosQuery);
		$ingresosPorCategoria = DB::select($ingresosPorCategoriaQuery);
		$promocionesAplicadas = DB::select($promocionesAplicadasQuery);
		$pagosEmpleados = DB::select($pagosEmpleadosQuery);
		$pagosServicios = DB::select($pagosServiciosQuery);
		return View::make('reportes.reporteGeneral',array(
			'sectionText' => '- Reporte general',
			'totalIngresos' => intval($totalIngresos[0]->total),
			'totalEgresos' => intval($totalEgresos[0]->total),
			'ingresosPorCategoria' => $ingresosPorCategoria,
			'promocionesAplicadas' => $promocionesAplicadas,
			'pagosEmpleados' => $pagosEmpleados,
			'pagosServicios' => $pagosServicios,
			'minDate' => $minDate,
			'maxDate' => $maxDate));
	}

}

?>