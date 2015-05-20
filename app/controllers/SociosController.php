<?php

class SociosController extends BaseController {
	
	public function index()
	{
		$tiposDePago = TipoDePago::all();
		$categorias = Categoria::all();
		$promociones = Promocion::all();
		$status = Status::all();
		$idsocio = Input::get('idsocio');
		$data = new stdClass();

		if(isset($idsocio)){

			$data->socioData = Socio::find($idsocio)->toArray();
			$pago = new Pago();
			$ultimoPago = $pago->obtenerUltimoPagoPorSocio($idsocio);
			
			$data->ultimoPago = null;
			$currentDate = new DateTime();
			$status = '';

			if(!is_null($ultimoPago)){
				$data->ultimoPago = $ultimoPago->toArray();
			}

			$data->status = Socio::getStatus($idsocio)->toArray();

			$data->ultimosPagos = Pago::where('idsocio','=',$idsocio)->take(5)->
									orderBy('id','desc')->get()->toArray();

			
			foreach ($data->ultimosPagos as &$uPago) {
				$promoAplicada = PromocionAplicada::where('idpago','=',$uPago['id'])->first();

				if(!is_null($promoAplicada)){
					$uPago['promo'] = $promoAplicada->idpromocion;
				}else{
					$uPago['promo'] = '-1';
				}
			}

		}

		return View::make('socios.status',array('sectionText' => '- Estado de socio',
			'tiposdepago'=>$tiposDePago,
			'categorias'=>$categorias,
			'status'=>$status,
			'promociones'=>$promociones,
			'idsocio'=>$idsocio,
			'socioData'=>json_encode($data)
			));
	}

	public function getStatus()
	{
		$idsocio = Input::get('idsocio');
		$data = new stdClass();

		$pago = new Pago();
		$ultimoPago = $pago->obtenerUltimoPagoPorSocio($idsocio);
		
		$data->ultimoPago = null;
		$currentDate = new DateTime();
		$status = '';

		if(!is_null($ultimoPago)){
			$data->ultimoPago = $ultimoPago->toArray();
		}

		$data->status = Socio::getStatus($idsocio)->toArray();

		$data->ultimosPagos = Pago::where('idsocio','=',$idsocio)->where('activo','!=','0')->take(5)->
								orderBy('id','desc')->get()->toArray();

		
		foreach ($data->ultimosPagos as &$uPago) {
			$promoAplicada = PromocionAplicada::where('idpago','=',$uPago['id'])->first();

			if(!is_null($promoAplicada)){
				$uPago['promo'] = $promoAplicada->idpromocion;
			}else{
				$uPago['promo'] = '-1';
			}
		}

		return json_encode($data);
	}

	public function updateSocio()
	{
		$result = new stdClass();
		try {
			$socio = Socio::find(Input::get('id'));

			$socio->nombre = Input::get("nombre");
			$socio->apellidop = Input::get("apellidop");
			$socio->apellidom = Input::get("apellidom");
			$socio->email = Input::get("email");
			$socio->comentario = Input::get("comentario");
			$socio->idcategoria = Input::get("idcategoria");
			$validator = $socio->getValidator();

			if($validator->fails()){
				throw new Exception($validator->messages()->first());
			}

			$socio->save();

			try{
				$gymlog = new Gymlog();
				$gymlog->idevento = 6; //Actualizacion de socio
				$gymlog->idusuario = Auth::user()->id;
				$gymlog->fecha = date("Y-m-d H:i:s", time());
				$gymlog->mensaje = "Socio actualizado: <a href='status?idsocio=".$socio->id."'> 0".$socio->id."</a>";
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