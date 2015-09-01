<?php

class PagosController extends BaseController {
	
	public function index()
	{
		$costosDePago = CostoDePago::all();
		$tiposDePago = TipoDePago::all();
		$categorias = Categoria::all();
		$promociones = Promocion::where('activa','=', '1')->get();

		return View::make('pagos.realizarpago',array('sectionText' => '- Realizar pago',
			'costosdepago'=>$costosDePago,
			'tiposdepago'=>$tiposDePago,
			'categorias'=>$categorias,
			'promociones'=>$promociones
			));
	}

	private function getInfoPagos(){

	}

	public function registrarPago(){	

		date_default_timezone_set("UTC");
		$pago = Input::get("pago");
		$pagoObj = new Pago($pago);
		$pagoObj->fecha = date("Y-m-d H:i:s", time());

		$tipoDePago = TipoDePago::find($pago['idtipodepago']);

		$ultimoPago = $pagoObj->obtenerUltimoPagoPorSocio($pago['idsocio']);
		$fromDate = new DateTime();

		if(!is_null($ultimoPago)){
			$fromDate = new DateTime($ultimoPago->proximopago);
		}
		$proximoPago = $pagoObj->calcularProximaFecha($tipoDePago, $fromDate, false);

		$pagoObj->proximoPago = $proximoPago;
		$pagoObj->save();

		try{
			
			$promo = Input::get("promocion");
			
			if($promo['id']!=null){
				$promoObj = new PromocionAplicada();
				$promoObj->idpromocion = $promo['id'];
				$promoObj->idpago = $pagoObj->id;
				$promoObj->save();
			}
		}catch(Exception $e){
			Log::error("No se pudo registrar la promocion en el pago");
		}

		try{

			$gymlog = new Gymlog();
			$gymlog->idevento = 2; //evento pago
			$gymlog->idusuario = Auth::user()->id;
			$gymlog->fecha = date("Y-m-d H:i:s", time());
			$gymlog->mensaje = "Pago realizado del socio: <a href='status?idsocio="
								.$pago['idsocio']."'> 0".$pago['idsocio']."</a> monto: "
								.$pago['monto']." tipo de pago: ".$tipoDePago->nombre;
			$gymlog->save();

		}catch(Exception $e){
			Log::error($e->getMessage());
		}

		return json_encode($pagoObj->id);
	}

	public function borrarPago(){
		$result = new stdClass();
		try {
			$pago = Pago::find(Input::get('id'));
			$pago->activo = false;

			$pago->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 7; //Pago eliminado
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Pago eliminado, ID de pago: ".$pago->id;
				$gymlog->save();

			}catch(Exception $e){
				Log::error($e->getMessage());
			}

			$result->Result = "OK";

		}catch(Exception $e){
					
			$result->Result = "Error";
			$result->Message = "Error: ".$e->getMessage();
		}

		return json_encode($result);
	}

	public function verificarPromocionYStatus(){

		$data = new stdClass();
		$idsocio = Input::get('idsocio');
		$idpromo = Input::get('idpromo');

		$promo = Promocion::find($idpromo);


		if($idpromo >0 && $promo->solounavez>0){
			$promos = DB::select("
								select count(s.id) as nSocios from promocionesaplicadas pa
								inner join pagos p on pa.idpago = p.id AND p.activo
								inner join socios s on p.idsocio = s.id
								where pa.idpromocion = ".intval($idpromo)." AND s.id = ".intval($idsocio));

			$data->promoFound = $promos[0]->nSocios;
		}else{
			$data->promoFound = 0;
		}

		$pago = new Pago();
		$ultimoPago = $pago->obtenerUltimoPagoPorSocio($idsocio);
		$data->ultimoPago = null;

		if(!is_null($ultimoPago)){
			$data->ultimoPago = $ultimoPago->toArray();
			if(new DateTime()<=new DateTime($ultimoPago->proximopago)){
				$data->status = 'activo';
			}else{
				$data->status = 'sinpagar';
			}
		}else{
			$data->status = 'inactivo';
		}

		$data->currentDate = new DateTime();

		return json_encode($data);
	}

	public function updatePago()
	{
		date_default_timezone_set("UTC");
		$result = new stdClass();
		$offset = Config::get('configKeys.offsetHoursInt');
		try {
			$pago = Pago::find(Input::get('id'));

			$pago->idtipodepago = Input::get("idtipodepago");
			$pago->monto = Input::get("monto");

			$newDate = DateTime::createFromFormat('Y-m-d H:i:s', Input::get("fechaWithOffset"));
			date_add($newDate, date_interval_create_from_date_string($offset." hours"));

			$pago->fecha = $newDate->format('Y-m-d H:i:s');
			$promocion = Input::get('idpromocion');

			$promocionAplicada = PromocionAplicada::where('idpago','=',$pago->id)->first();

			$tipoDePagoTienePromocion = Promocion::where('id','=',$promocion)->where('idtipodepago','=',$pago->idtipodepago)->first();

			if(!$promocionAplicada && $promocion != '-1' && $tipoDePagoTienePromocion){
				$promoAplicada = new PromocionAplicada();
				$promoAplicada->idpago = $pago->id;
				$promoAplicada->idpromocion = $promocion;
				$promoAplicada->save();
			}else if(($promocionAplicada && $promocion == '-1') || ($promocionAplicada && !$tipoDePagoTienePromocion)){
				$promocionAplicada->delete();
			}else if($promocionAplicada && $promocion != '-1' && $tipoDePagoTienePromocion){
				$promocionAplicada->idpromocion = $promocion;
				$promocionAplicada->save();
			}

			$pago->proximopago = $pago->calcularProximaFecha(TipoDePago::find($pago->idtipodepago), new DateTime($pago->fecha), true);

			$pago->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 8; //Pago modificado
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Pago modificado: ".$pago->id;
				$gymlog->save();

			}catch(Exception $e){
				Log::error($e->getMessage());
			}

			$result->Result = "OK";

		}catch(Exception $e){
					
			$result->Result = "Error";
			$result->Message = "Error: ".$e->getMessage();
		}

		return json_encode($result);
	}

	
}

?>